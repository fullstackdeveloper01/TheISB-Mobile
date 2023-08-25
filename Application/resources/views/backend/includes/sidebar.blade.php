<aside class="vironeer-sidebar">
    <div class="overlay"></div>
    <div class="vironeer-sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="vironeer-sidebar-logo">
            <img src="{{ asset($settings['website_light_logo']) }}" alt="{{ $settings['website_name'] }}" />
        </a>
    </div>
    <div class="vironeer-sidebar-menu" data-simplebar>
        <div class="vironeer-sidebar-links">
            <div class="vironeer-sidebar-links-cont">
                <a href="{{ route('admin.dashboard') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'dashboard') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-th-large"></i>{{ __('Dashboard') }}</span>
                    </p>
                </a>
                <a href="{{ route('admin.sections.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'sections') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-puzzle-piece"></i>{{ __('Sections') }}</span>                       
                    </p>
                </a>
                <a href="{{ route('admin.students') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'students') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-users"></i>{{ __('Students') }}</span>                       
                    </p>
                </a>
                <a href="{{ route('admin.homework.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'homework') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-file"></i>{{ __('Homework') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.highlighters.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'highlighters') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-th-list"></i>{{ __('Highlighter') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.events.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'events') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-calendar"></i>{{ __('Upcoming Events') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.galleries.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'galleries') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-file-image"></i>{{ __('Gallery') }}</span>                       
                    </p>
                </a>
				<a href="{{ url('admin/academicTimeTable') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'academicTimeTable') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-file"></i>{{ __('Time Table') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.syllabus.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'syllabus') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-file-pdf"></i>{{ __('Syllabus') }}</span>                       
                    </p>
                </a>
				<a href="{{ url('admin/timeTable') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'timeTable') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-calendar"></i>{{ __('Calendar') }}</span>
                    </p>
                </a>
				<a href="javascript:void(0)"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'users') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-bookmark"></i>{{ __('Exam Schedule') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.announcements.index')}}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'announcements') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-bullhorn"></i>{{ __('Announcement') }}</span>                       
                    </p>
                </a>
                <a href="{{ route('admin.noticeBoard.index')}}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'noticeBoard') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-clipboard"></i>{{ __('Notice Board') }}</span>                       
                    </p>
                </a>
				<a href="javascript:void(0)"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'users') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-birthday-cake"></i>{{ __('Birthdays') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.queries.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'queries') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-question"></i>{{ __('Querys') }}</span>                       
                    </p>
                </a>
				<a href="{{ route('admin.knowledgeBase.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'knowledgeBase') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-book"></i>{{ __('Knowledge Base') }}</span>                 
                    </p>
                </a>
                <a href="{{ route('admin.popup-notice.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'popup-notice') current @endif">
                    <p class="vironeer-sidebar-link-title"><span><i class="fa fa-bell"></i>{{ __('PopUp Notice') }}</span></p>
                </a>
                <a href="{{ route('admin.sliders.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'sliders') current @endif">
                    <p class="vironeer-sidebar-link-title"><span><i class="fa fa-flag"></i>{{ __('Slider') }}</span></p>
                </a>
                <a href="{{ route('admin.leaveReques.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'leaveApplication') current @endif">
                    <p class="vironeer-sidebar-link-title"><span><i class="fa fa-file"></i>{{ __('Leave Application') }}</span></p>
                </a>
                <a href="{{ route('admin.notificationTemplate.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'notificationTemplate') current @endif">
                    <p class="vironeer-sidebar-link-title"><span><i class="fa fa-book"></i>{{ __('Notification Template') }}</span></p>
                </a>
                <a href="{{ route('admin.pushNotification.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'pushNotification') current @endif">
                    <p class="vironeer-sidebar-link-title"><span><i class="fa fa-paper-plane"></i>{{ __('Push Notification') }}</span></p>
                </a>
            </div>
            <div class="vironeer-sidebar-links-cont">   
                <a href="{{ route('admin.settings.index') }}"
                    class="vironeer-sidebar-link @if (request()->segment(2) == 'settings' || request()->segment(2) == 'categories' || request()->segment(2) == 'subCategories' || request()->segment(2) == 'cities' || request()->segment(2) == 'amenities' || request()->segment(2) == 'splashScreen' || request()->segment(2) == 'introScreens') current @endif">
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fa fa-cog"></i>{{ __('Settings') }}</span>
                    </p>
                </a>
            </div>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link @if (request()->segment(2) == 'student-report') active @endif" data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-plus-square"></i>{{ __('Reports') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.studentReport') }}"
                            class="vironeer-sidebar-link @if (request()->segment(2) == 'student-report') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Student Reports') }}</span></p>
                        </a> 
                    </div>
                </div>
            </div>
            <div class="vironeer-sidebar-links-cont">
                <div class="vironeer-sidebar-link @if (request()->segment(2) == 'transportList' || request()->segment(2) == 'academicList' || request()->segment(2) == 'complaintType') active @endif" data-dropdown>
                    <p class="vironeer-sidebar-link-title">
                        <span><i class="fas fa-plus-square"></i>{{ __('Complaints') }}</span>
                        <span class="arrow"><i class="fas fa-chevron-right fa-sm"></i></span>
                    </p>
                    <div class="vironeer-sidebar-link-menu">
                        <a href="{{ route('admin.complaintType.index') }}"
                            class="vironeer-sidebar-link @if (request()->segment(2) == 'complaintType') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Complaints Type') }}</span></p>
                        </a>
                        <a href="{{ route('admin.transportList') }}"
                            class="vironeer-sidebar-link @if (request()->segment(2) == 'transportqueries') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Transport Query') }}</span></p>
                        </a>
                        <a href="{{ route('admin.academicList') }}"
                            class="vironeer-sidebar-link @if (request()->segment(2) == 'academicqueries') current @endif">
                            <p class="vironeer-sidebar-link-title"><span>{{ __('Academic Query') }}</span></p>
                        </a>
                    </div>
                </div>
            </div>
            {{--<div class="vironeer-sidebar-links-cont">
                <a href="javascript::void()" class="vironeer-link-confirm vironeer-sidebar-link">
                    <form action="{{ route('admin.logout') }}" method="POST" class="vironeer-link-confirm vironeer-sidebar-link">
                        @csrf
                        <button class="dropdown-item p-0 logout-btn">                        
                            <p class="vironeer-sidebar-link-title">
                                <span><i class="fas fa-sign-out-alt p-1"></i>{{ __('Logout') }}</span>
                            </p>
                        </button>
                    </form>
                </a>
            </div>--}}
        </div>
    </div>
</aside>
