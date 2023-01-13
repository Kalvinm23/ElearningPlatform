<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav mt-4">
                @if(Auth::user()->permission == 2)
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        Students
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="/users/create">
                                Add Student
                            </a>
                            <a class="nav-link" href="/users/">
                                Search Student
                            </a>
                        </nav>
                    </div>
                    <a class="nav-link" href="/courses/">
                        Courses
                    </a>
                    <a class="nav-link" href="/units/">
                        Units
                    </a>
                    <a class="nav-link" href="/resources/">
                        Resources
                    </a>
                    <a class="nav-link" href="/helpsheets/">
                        Helpsheets
                    </a>
                    <a class="nav-link" href="/professionalbodies/">
                        Professional Bodies
                    </a>
                    <a class="nav-link" href="/versions/">
                        Versions
                    </a>
                @else
                    <a class="nav-link" href="/">
                        My Courses
                    </a>
                    <a class="nav-link" href="/contactus">
                        Contact Us
                    </a>
                @endif
                
                @if(!empty($assignments))
                    @if(count($assignments) > 0)
                        @foreach($assignments as $assignmentnav)
                            <a class="nav-link" href="/assignments/{{$assignmentnav->id}}">
                                {{$assignmentnav->name}}
                            </a>
                        @endforeach
                        <a class="nav-link" href="/units/{{$assignmentnav->unit_id}}">
                            Return to Unit
                        </a>
                    @endif
                @endif
          </div>
      </div>
      <div class="sb-sidenav-footer">
          <div class="small">Logged in as:</div>
          {{ Auth::user()->first_name }}  {{ Auth::user()->last_name }}
      </div>
  </nav>
</div>