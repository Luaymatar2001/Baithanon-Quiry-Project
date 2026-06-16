<div class="form-card combined-card">
    <!-- القسم الأول -->
    <div class="card1">
        <div class="card-section card-header card_color">
            <h2 class="main-title"><i class="fa-duotone fa-solid fa-user-check"></i> البوابة الإلكترونية لتحديث بيانات
                أسر مدينة بيت حانون: <i class="fa-solid fa-feather-pointed" style="font-size:23px;"></i>
            </h2>
            <!-- 👇 زر التحويل هنا -->
            <a href="https://beithanoun.com/" class="donation-link" target="_blank" rel="noopener noreferrer">
                <div class="icon-box">
                    <i class="fa-solid fa-hand-holding-heart"></i>
                </div>
                <div class="link-text">
                    <p class="title">الانتقال إلى الصندوق</p>
                    <p class="sub"> بيت حانون التكافلي المستدام </p>
                </div>
                <i class="fa-solid fa-chevron-left chevron"></i>
            </a>
        </div>
        <div class="card-section card-blue">
            <h2 class="title2"><i class="fa-duotone fa-solid fa-lock"></i> تسجيل الدخول </h2>

            <p> يهدف هذا النظام إلى تحديث وتسجيل بيانات مواطني مدينة بيت حانون – المحافظة الشمالية/قطاع غزة، وذلك لتمكين
                الجهات المختصة
                من تقديم المساعدات والخدمات المختلفة بالشراكة مع المؤسسات المحلية والدولية.
            </p>
            {{-- <small>
                تم تصميم هذه البوابة لتكون منصة موحدة تجمع البيانات الموثوقة، وتسهّل مشاركتها مع المؤسسات الشريكة بما
                يضمن
                سرعة الوصول
                إلى المعلومات، وتحسين جودة الخدمات المقدمة للأهالي، وتعزيز فعالية برامج الدعم الإنساني والتنمية
                المجتمعية.
            </small> --}}
            <div class="stats-container" wire:ignore>
                <div class="stat-box" style="height:70px;">
                    <div class=" stat-info">
                        <h3>عدد الأسر المسجلة</h3>
                        <p class="counter" data-target="{{$familiesCount}}">0</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-house-chimney-user"></i></div>
                </div>

                <div class="stat-box" style="height:70px;">
                    <div class="stat-info">
                        <h3>عدد الأفراد المسجلين لدينا </h3>
                        <p class="counter" data-target="{{$partnersCount+$childrenCount+$familiesCount}}">0</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-people-group"></i></div>
                </div>

            </div>
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
                    <input type="number" id="PersonId" wire:model.defer="id" maxlength="9" placeholder="000000000"
                        inputmode="numeric">
                    @error('id')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mobileNum">أدخل رقم الجوال :</label>
                    <input type="tel" maxlength="10" style="text-align: right;" pattern="[0-9]{10}" id="mobileNum"
                        wire:model.defer="mobileNum" value="0567275232" maxlength="10" placeholder="0500000000"
                        inputmode="numeric">
                    @error('mobileNum')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-actions">
                    <button type="submit">إستعلام</button>
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
                    <input type="text" wire:model.defer="answer" required placeholder="أدخل الإجابة الصحيحة">
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
        <ol style="padding-right: 20px; line-height: 2;">
            <li>يُعد التسجيل في النظام المرجع الأساسي لبيانات أسر مدينة بيت حانون، وقد تتم مشاركة البيانات مع المؤسسات
                الشريكة
                لتسهيل تقديم الخدمات والمساعدات.</li>

            <li>يرجى التأكد من إدخال بيانات دقيقة وصحيحة، حيث تسهم جودة البيانات في تحسين الاستفادة من الخدمات والبرامج
                المتاحة.
            </li>

            <li>سيتم إرسال الإشعارات والتنبيهات المتعلقة بالتحديثات والخدمات عبر أرقام الهواتف المسجلة في النظام.</li>

            <li>بإتمام عملية التسجيل، فإنك توافق على استخدام ومشاركة بياناتك مع الجهات الشريكة لأغراض تقديم الخدمات
                والمساعدات.
            </li>

            <li>التسجيل في النظام لا يضمن الحصول على المساعدة، إذ تخضع الطلبات للمعايير والإجراءات المعتمدة، وقد تتطلب
                زيارة
                ميدانية للتحقق من البيانات.</li>

            <li>يختص النظام بتسجيل وتحديث بيانات أسر مدينة بيت حانون، بما يسهم في دعم جهود المؤسسات المحلية والدولية
                العاملة في
                قطاع غزة.</li>

            <li>تشمل قاعدة البيانات الأسر المسجلة حتى تاريخ 25/10/2025، وسيتم استكمال تحديث وإضافة البيانات بشكل دوري.
            </li>
        </ol>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
    if (typeof Swal !== 'undefined') {
        if (localStorage.getItem('family_update_alert_shown')) {
            
            return; // لا تعرضه مرة ثانية
            
            }
        Swal.fire({
            title: 'أهلاً وسهلاً بكم 🌷',
            html: `
            <div style="text-align:right; line-height:2; font-size:16px;">
                نرحب بكم في <strong>المنظومة الإلكترونية لتسجيل وتحديث بيانات أسر مدينة بيت حانون</strong>
                <strong style="color:#dc3545;">
                    بالشراكة مع صندوق بيت حانون التكافلي المستدام
                </strong>
                ، والتي تهدف إلى بناء قاعدة بيانات دقيقة تسهم في تطوير الخدمات وتعزيز التكافل الاجتماعي.
                يرجى التأكد من إدخال البيانات بشكل صحيح لضمان الاستفادة من الخدمات والبرامج المتاحة.
               <br>
            </div>
            `,
            confirmButtonText: 'بدء التسجيل',
            confirmButtonColor: '#1BC5BD',
            width: 500
        });
    }
});
</script>


<script>
    function startCounters() {
        const counters = document.querySelectorAll(".counter");
    
        counters.forEach(counter => {
            counter.innerText = "0";
    
            const target = +counter.getAttribute("data-target");
            let current = 0;
    
            const increment = Math.ceil(target / 80);
    
            const update = () => {
                current += increment;
    
                if (current < target) {
                    counter.innerText = current.toLocaleString();
                    requestAnimationFrame(update);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
    
            update();
        });
    }
    
    // تشغيل أول مرة
    document.addEventListener("DOMContentLoaded", () => {
        startCounters();
    });
    
    // مهم جداً مع Livewire (إعادة تحميل DOM)
    document.addEventListener("livewire:navigated", () => {
        startCounters();
    });

    counter.style.transform = "scale(1.2)";
    setTimeout(() => counter.style.transform = "scale(1)", 200);
</script>