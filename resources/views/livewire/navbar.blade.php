<nav class="navbar" dir="rtl">
    <div class="navbar-container">

        <!-- الشعار (يمين) -->
        <div class="navbar-logo">
            <img src="{{asset('images/favicon.png')}}" alt="الشعار">
            <span>جمعية أهالي بيت حانون</span>
        </div>

        <!-- زر تسجيل الخروج (شمال) -->
        <button class="logout-btn" onclick="window.location='{{ route('logout') }}'">
            خروج &nbsp;
            <i class="fa-solid fa-arrow-right-from-bracket fa-flip-horizontal"></i>
        </button>

    </div>
</nav>