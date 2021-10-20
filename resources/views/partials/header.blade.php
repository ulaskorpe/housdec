<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Yönetim Paneli
                    </div>
                </div>

                <button type="button"  hidden data-toggle="modal" data-target="#newOrder"
                        onclick="showModal('{{ route('profile') }}','Profil Güncelle')" id="profile-button"></button>

                <button type="button"  hidden data-toggle="modal" data-target="#newOrder"
                onclick="showModal('{{ route('update-password') }}','Şifre Güncelle')" id="pw-button"></button>

                <ul class="navbar-nav header-right">


                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                            <img src="" width="20" alt="" id="avatar-admin"/>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="#" onclick="$('#profile-button').click();" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ml-2">Düzenle </span>
                            </a>

                            <a href="#" onclick="$('#pw-button').click();" class="dropdown-item ai-icon">
                                <svg id="icon-key" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ml-2">Şifre Güncelle </span>
                            </a>

                            <a href="{{ route('logout') }}" class="dropdown-item ai-icon" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg"
                                     class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ml-2">Çıkış </span>
                            </a>



                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>