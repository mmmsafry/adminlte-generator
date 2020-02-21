<li class="{{ Request::is('members*') ? 'active' : '' }}">
    <a href="{{ route('members.index') }}"><i class="fa fa-edit"></i><span>Members</span></a>
</li>

<li class="{{ Request::is('configurations*') ? 'active' : '' }}">
    <a href="{{ route('configurations.index') }}"><i class="fa fa-edit"></i><span>Configurations</span></a>
</li>

