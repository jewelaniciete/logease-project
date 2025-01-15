{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-lock" :link="backpack_url('user')" />
<x-backpack::menu-item title="Departments" icon="la la-building" :link="backpack_url('department')" />
<x-backpack::menu-item title="Keys" icon="la la-key" :link="backpack_url('key')" />
<x-backpack::menu-item title="Teachers" icon="la la-group" :link="backpack_url('teacher')" />
<x-backpack::menu-item title="Borrows" icon="la la-level-up" :link="backpack_url('barrow')" />
<x-backpack::menu-item title="Returns" icon="la la-mail-reply" :link="backpack_url('retrun')" />
<x-backpack::menu-item title="Archive borrows" icon="la la-folder" :link="backpack_url('archive-borrow')" />
<x-backpack::menu-item title="Archive returns" icon="la la-folder" :link="backpack_url('archive-return')" />

