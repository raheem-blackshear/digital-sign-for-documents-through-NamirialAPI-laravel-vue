@hasrole('admin')
    <li class="{{ Request::is('users*') ? 'active' : '' }}">
        <a href="{!! route('admin.users.index') !!}"><i class="fa fa-edit"></i><span>Agente</span></a>
    </li>
@endhasrole
<li class="{{ Request::is('sales*') ? 'active' : '' }}">
    <a href="{!! route('admin.sales.index') !!}"><i class="fa fa-edit"></i><span>Vendite</span></a>
</li>

