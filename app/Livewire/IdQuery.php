<?php

namespace App\Livewire;

use App\Models\household;
use Livewire\Component;

use function Laravel\Prompts\table;

class IdQuery extends Component
{
    public $id;
    public $mobileNum;
    public $notification = '';
    public $step = 1; // 1: إدخال الهوية، 2: تحميل، 3: أسئلة
    public $houseHold = null;
    public $questionType;
    public $answer;
    public $questionLabel;
    public $hint;
    public function submit()
    {
        $this->validate([
            'id' => 'required|digits:9',
            'mobileNum' => 'required|digits:10',
        ]);

        // البحث عن صاحب الهوية
        $this->houseHold = household::with('children')->where('PersonId', $this->id)->first();
        // إذا الهوية غير موجودة
        if (!$this->houseHold) {
            $this->addError('id', 'رقم الهوية غير موجود. تواصل مع الدعم الفني.');
            return;
        }
        // Normalize numbers
        $dbPhone = preg_replace('/[^0-9]/', '', $this->houseHold->Phone_Number);
        $inputPhone = preg_replace('/[^0-9]/', '', $this->mobileNum);

        // Fix numbers stored as +970 or missing 0
        if (str_starts_with($dbPhone, '970')) {
            $dbPhone = '0' . substr($dbPhone, 3);
        }

        // رقم الجوال غير موجود في السجل
        if (empty($dbPhone)) {
            $this->addError('mobileNum', 'رقم الجوال غير موجود في سجلاتنا، تواصل مع الدعم الفني.');
            return;
        }

        // التحقق الصحيح من التطابق بعد التطبيع
        if ($dbPhone !== $inputPhone) {
            $firstTwo = substr($dbPhone, 0, 2);
            $lastTwo = substr($dbPhone, -2);
            $mobileHint = $lastTwo . '******' . $firstTwo;

            $this->addError('mobileNum', 'رقم الجوال غير صحيح. تلميح: ' . $mobileHint);
            return redirect()->back()->withInput();
        }

        // نجاح الانتقال للخطوة التالية
        $this->step = 2;
        $this->dispatch('goToQuestions', data: $this->houseHold);
    }


    public function goToQuestions()
    {
        if (!$this->houseHold) abort(404);

        // 1️⃣ إذا يوجد أبناء
        if ($this->houseHold->children->isNotEmpty()) {

            $child = $this->houseHold->children->first();
            $this->questionType = 'child';
            $this->questionLabel = "ما هو رقم هوية {$child->FName} ؟";
        }
        // 2️⃣ إذا لا يوجد أبناء ولكن يوجد زوج/زوجة
        elseif ($this->houseHold->partner->isNotEmpty()) {

            $this->questionType = 'partner';
            $partner = $this->houseHold->partner->first();
            $this->questionLabel = "ما هو رقم هوية {$partner->FName}؟";
        }
        // 3️⃣ لا أبناء ولا زوج
        else {

            $this->questionType = 'SName';
            $this->questionLabel = "ما أسم والدك ؟";
        }

        $this->step = 3;
    }


    public function finish()
    {
        if ($this->questionType === 'partner') {

            $partner = $this->houseHold->partner->first();

            if (!$partner || $this->answer != $partner->PersonId) {
                return $this->addError('answer', 'الرقم غير صحيح ❌');
            }
        }

        if ($this->questionType === 'child') {
            $childrenIds = $this->houseHold->children->pluck('PersonId')->toArray();
            if (!in_array($this->answer, $childrenIds)) {
                return $this->addError('answer', 'الرقم غير صحيح ❌');
            }
        }

        if ($this->questionType === 'SName') {

            if ($this->answer != $this->houseHold->SName) {
                return $this->addError('answer', 'الاسم غير صحيح ❌');
            }
        }

        $this->resetValidation();
        session(['household_verified' => $this->houseHold->id, 'household_name' => $this->houseHold->FName]);

        cache()->increment('homepage_visits' , 1);

        return redirect()->to('/details');
    }


    public function render()
    {
        return view('livewire.id-query');
    }
}
