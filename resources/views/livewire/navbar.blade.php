<nav class="navbar" dir="rtl">
    <div class="navbar-container">

        <!-- الشعار (يمين) -->
        <div class="navbar-logo">
            <img src="{{asset('images/favicon.png')}}" alt="الشعار" style="border-radius: 100px;">
            <span style="color:rgb(2, 54, 2)">صندوق بيت حانون التكافلي المستدام</span>
        </div>

        <div style="display: flex; ">
            <!-- رسالة ترحيب -->
            <div class="navbar-welcome">
                أهلاً وسهلاً بك، {{ $FName }} !
            </div>
            <!-- زر تسجيل الخروج (شمال) -->
            <button class="logout-btn" onclick="window.location='{{ route('logout') }}'">
                خروج &nbsp;
                <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i>
            </button>
        </div>
    </div>
</nav>