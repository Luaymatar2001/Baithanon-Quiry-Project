<div class="form-card combined-card">
    <!-- القسم الأول -->
    <div class="card1">
        <div class="card-section card-header card_color" >
        <h2 class="main-title" ><i class="fa-duotone fa-solid fa-user-check"></i> بوابة تسجيل بيانات مواطني
            مدينة بيت حانون :</h2>
            </div>
        <div class="card-section card-blue">
            <h2 class="title2"><i class="fa-duotone fa-solid fa-lock"></i> تسجيل الدخول </h2>
            <p> يهدف هذا النظام إلى تحديث وتسجيل بيانات مواطني مدينة بيت حانون – المحافظة الشمالية/قطاع غزة، وذلك لتمكين
                الجهات المختصة
                من تقديم المساعدات والخدمات المختلفة بالشراكة مع المؤسسات المحلية والدولية.
            </p>
            <small>
                تم تصميم هذه البوابة لتكون منصة موحدة تجمع البيانات الموثوقة، وتسهّل مشاركتها مع المؤسسات الشريكة بما
                يضمن
                سرعة الوصول
                إلى المعلومات، وتحسين جودة الخدمات المقدمة للأهالي، وتعزيز فعالية برامج الدعم الإنساني والتنمية
                المجتمعية.
            </small>
        </div>
        
        <!-- القسم الثاني -->
        {{-- مرحلة إدخال رقم الهوية --}}
        @if ($step == 1)
        <div class="card-section1 card-cadet">
            <div style="margin-bottom: 1rem; border-bottom: 2px solid #1BC5BD; padding-bottom: 0.5rem;">
            <h2 class="main-title">الإستعلام عن رقم الهوية:</h2>
            </div>
            <form wire:submit.prevent="submit">
                <div class="form-group">
                    <label for="id">أدخل رقم الهوية :</label>
                    <input type="number" id="PersonId" wire:model="id" maxlength="9" placeholder="000000000">
                    @error('id')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mobileNum">أدخل رقم الجوال :</label>
                    <input type="number" id="mobileNum" wire:model="mobileNum" value="0567275232" maxlength="10"
                        placeholder="0500000000">
                    @error('mobileNum')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="submit">أستعلام</button>
                </div>
            </form>
        </div>
        @endif


        {{-- شاشة التحميل --}}
        @if ($step == 2)
        <div class="loading-box">
            <div class="spinner"></div>
            <p>جاري التحقق من بياناتك...</p>
        </div>


        @endif


        {{-- مرحلة أسئلة التحقق --}}
        {{-- الخطوة 3: أسئلة تحقق --}}
        {{-- الخطوة 3: أسئلة تحقق --}}
        @if($step === 3)
        <div class="verify-container">
            <div style="margin-bottom: 1rem; border-bottom: 2px solid #1BC5BD; padding-bottom: 0.5rem;">
            <h2 class="main-title">التحقق الإضافي:</h2>
            </div>
            {{-- السؤال الديناميكي --}}
            <div class="verify-box">
                <div class="verify-content">
                    <label>{{ $questionLabel }}</label>
                    <input type="text" wire:model="answer" required placeholder="أدخل الإجابة الصحيحة">
                    @error('answer')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <button class="verify-btn" wire:click="finish">تحقق ✔️</button>
        </div>
        @endif
    </div>
    <script>
        document.addEventListener('livewire:initialized', () => {
                Livewire.on('goToQuestions', () => {
                   @this.call('goToQuestions');
                });
            });
    </script>
<div class="card-section" style="
    border: 4px solid #1BC5BD;
    background-color: #F0FDFA;
    border-radius: 10px;
    padding: 1rem;
    margin: 1rem;
box-shadow:
    0 8px 20px rgba(15, 118, 110, 0.18),
    0 2px 6px rgba(0, 0, 0, 0.06);">
    <h2 style="font-size: 1.5rem; margin-bottom: 1rem; color: #cc4343ff;
        padding-bottom: 0.5rem solid #1BC5BD;">
            <i class="fa-solid fa-id-card"></i>
            تعليمات مهمة
        </h2>
        <p>
            1. عملية التسجيل هنا تُعتبر الأساس المعتمد لمشاركة بيانات المواطنين مع المؤسسات المحلية والدولية بهدف تسهيل
            إجراءات
            الإغاثة والخدمات.

        </p>
        <p>
            2. دقّة وصحّة البيانات التي تقوم بإدخالها تُسهم مباشرة في تعزيز جهود الإيواء والإغاثة المقدّمة للمواطنين.

        </p>
        <p>
            3. سيتم إرسال جميع إشعارات التحديث والمساعدات عبر أرقام الهواتف المسجّلة في النظام.
        </p>
        <p>
            4. استخدامك للنظام يعني موافقتك على مشاركة بياناتك مع المؤسسات الشريكة لتمكينها من تقديم الخدمات والمساعدات
            اللازمة.
        </p>
        <p>

            5. تسجيلك في النظام لا يعني بالضرورة حصولك على المساعدة الإغاثية، حيث يتطلّب الأمر زيارة ميدانية من الباحث
            المختص.
        </p>
        <p>
            6. هذا النظام يختص بتسجيل الكشوفات الخاصة بأسر مدينة بيت حانون، وسيتم مشاركة البيانات مع المؤسسات المحلية
            والدولية في
            قطاع غزة للاستفادة من الخدمات المتاحة.
        </p>
        <p>
            7. يشمل النظام بيانات جميع الأسر في مدينة بيت حانون حتى تاريخ 25-10-2025، وسيتم تحديث بيانات أرباب الأسر غير
            المضافة في وقت لاحق.
        </p>

    </div>
</div>