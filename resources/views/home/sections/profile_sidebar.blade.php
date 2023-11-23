<div class="myaccount-tab-menu nav" role="tablist">

    <a href="{{route('user.profile.index')}}" {{request()->is('profile')?'class=active':''}} >
        <i class="sli sli-user ml-1"></i>
        پروفایل
    </a>

    <a href="{{route('user.orders')}}" class="{{request()->is('profile/orders')?'active':''}}" >
        <i class="sli sli-basket ml-1"></i>
        سفارشات
    </a>

    <a href="{{route('user.addresses.index')}}" class="{{request()->is('profile/addresses')?'active':''}}">
        <i class="sli sli-map ml-1"></i>
        آدرس ها
    </a>

    <a href="{{route('user.wishList')}}" class="{{request()->is('profile/whisList')?'active':''}}" >
        <i class="sli sli-heart ml-1"></i>
        لیست علاقه مندی ها
    </a>

    <a href="{{route('user.comments')}}" {{request()->is('profile/comments')?'class=active':''}}>
        <i class="sli sli-bubble ml-1"></i>
        نظرات
    </a>

<a href="{{url('/logout')}}">
        <i class="sli sli-logout ml-1"></i>
        خروج
    </a>

</div>
