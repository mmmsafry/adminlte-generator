<li class="{{ Request::is('members*') ? 'active' : '' }}">
    <a href="{{ route('members.index') }}"><i class="fa fa-edit"></i><span>Members</span></a>
</li>

<<<<<<< HEAD
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-edit"></i><span>Users</span></a>
=======
<li class="{{ Request::is('configurations*') ? 'active' : '' }}">
    <a href="{{ route('configurations.index') }}"><i class="fa fa-edit"></i><span>Configurations</span></a>
>>>>>>> b6101325740bfae1b9b5026ab25fd52dd2c78397
</li>

