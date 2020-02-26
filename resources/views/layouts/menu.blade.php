<li class="{{ Request::is('members*') ? 'active' : '' }}">
    <a href="{{ route('members.index') }}"><i class="fa fa-edit"></i><span>Members</span></a>
</li>

<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}"><i class="fa fa-edit"></i><span>Users</span></a>
</li>

