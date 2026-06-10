<?php

namespace App\Http\Controllers;

use App\Models\MemberRequest;
use App\Models\household;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MemberRequestController extends Controller
{
    public function store(Request $request)
    {

        $householdId = session('household_verified');
        if (!$householdId) {
            abort(403, 'Unauthorized');
        }
        $household = household::where('id', session('household_verified'))
            ->firstOrFail();

        $rules = [
            'FName' => 'required|string|max:20',
            'SName' => 'sometimes|nullable|string|max:20',
            'TName' => 'sometimes|nullable|string|max:20',
            'LName' => 'sometimes|nullable|string|max:20',
            'PersonId' => [
                'required',
                'digits:9',
                'unique:heads_households,PersonId',
                'unique:heads_children,PersonId',
                'unique:heads_households,PersonId'
            ],


            'relation' => 'required|in:زوجة,ابن,ابنة',
            'health_status' => 'required|in:0,1,2,3,4,5,6,7,8,9,10',
            'BirthDate' => 'required|date|before:today',
            'desc_health_status_member' => 'nullable|string|max:255',
        ];

        if ($request->relation === 'ابن' || $request->relation === 'ابنة') {
            $rules['birth_certificate'] = 'required|image|max:2048';
            $rules['household_id_image'] = 'required|image|max:2048';
        } elseif ($request->relation === 'زوجة') {
            $rules['identity_image'] = 'required|image|max:2048';
        }
        //
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $identityPath = null;
        $birthCertificatePath = null;
        $householdIdImagePath = null;

        if ($request->hasFile('identity_image')) {
            $identityPath = $request->file('identity_image')->store('MemberRequestImage/identity_images', 'public_uploads');
        }
        if ($request->hasFile('birth_certificate')) {
            $birthCertificatePath = $request->file('birth_certificate')->store('MemberRequestImage/birth_certificates', 'public_uploads');
        }
        if ($request->hasFile('household_id_image')) {
            $householdIdImagePath = $request->file('household_id_image')->store('MemberRequestImage/household_id_images', 'public_uploads');
        }

        MemberRequest::create([
            'household_id' => $household->PersonId,
            'FName' => $validated['FName'],
            'SName' => $validated['SName'] ?? null,
            'TName' => $validated['TName'] ?? null,
            'LName' => $validated['LName'] ?? null,
            'PersonId' => $validated['PersonId'],
            'relation' => $validated['relation'],
            'BirthDate' => $validated['BirthDate'],
            'health_status' => $validated['health_status'],
            'desc_health_status_member' => $validated['desc_health_status_member'] ?? null,
            'identity_image' => $identityPath,
            'birth_certificate' => $birthCertificatePath,
            'household_id_image' => $householdIdImagePath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('message', 'تم إرسال طلب إضافة فرد للعائلة بنجاح');
    }

    public function pending()
    {
        $requests = MemberRequest::query()
            ->where('status', 'pending')
            ->latest('created_at')
            ->get();

        return view('Dashboard.member-requests.pending', compact('requests'));
    }

    public function accepted()
    {
        $requests = MemberRequest::query()
            ->where('status', 'accepted')
            ->latest('created_at')
            ->get();

        return view('Dashboard.member-requests.accepted', compact('requests'));
    }

    public function rejected()
    {
        $requests = MemberRequest::query()
            ->where('status', 'rejected')
            ->latest('created_at')
            ->get();

        return view('Dashboard.member-requests.rejected', compact('requests'));
    }

    public function accept(int $id)
    {
        $req = MemberRequest::findOrFail($id);

        $req->update([
            'status' => 'accepted',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'reject_reason' => null,
        ]);

        return redirect()->route('member-requests.pending')->with('message', 'تم قبول الطلب');
    }

    public function reject(Request $request, int $id)
    {
        $req = MemberRequest::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'reject_reason' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $req->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'reject_reason' => $request->input('reject_reason'),
        ]);

        return redirect()->route('member-requests.pending')->with('message', 'تم رفض الطلب');
    }
}
