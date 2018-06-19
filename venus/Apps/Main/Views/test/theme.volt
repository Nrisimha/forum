{% extends 'layouts/bs.volt' %} {% block page_content %}

<section>
    <!-- Page content-->
    <div class="content-wrapper">
            <h3>Bug tracker</h3>
            <div class="row">
               <div class="col-md-4">
                  <!-- Aside panel-->
                  <div class="panel b">
                     <div class="panel-body bb">
                        <p>Overvall progress</p>
                        <div class="table-grid table-grid-align-middle mv">
                           <div class="col">
                              <div class="progress progress-xs m0">
                                 <div style="width:48%" class="progress-bar progress-bar-info">48%</div>
                              </div>
                           </div>
                           <div class="hidden-xs col wd-xxs text-right">
                              <div class="text-bold text-muted">48%</div>
                           </div>
                        </div>
                     </div>
                     <div class="panel-body">
                        <p>Metrics</p>
                        <div class="row text-center">
                           <div class="col-xs-3 col-md-6 col-lg-3">
                              <div class="inline mv">
                                 <div data-sparkline="" values="20,80" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#23b7e5&quot;]" class="sparkline"><canvas width="50" height="50" style="display: inline-block; width: 50px; height: 50px; vertical-align: top;"></canvas></div>
                              </div>
                              <p class="mt-lg">Issues</p>
                           </div>
                           <div class="col-xs-3 col-md-6 col-lg-3">
                              <div class="inline mv">
                                 <div data-sparkline="" values="60,40" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#27c24c&quot;]" class="sparkline"><canvas width="50" height="50" style="display: inline-block; width: 50px; height: 50px; vertical-align: top;"></canvas></div>
                              </div>
                              <p class="mt-lg">Bugs</p>
                           </div>
                           <div class="col-xs-3 col-md-6 col-lg-3">
                              <div class="inline mv">
                                 <div data-sparkline="" values="20,80" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#ff902b&quot;]" class="sparkline"><canvas width="50" height="50" style="display: inline-block; width: 50px; height: 50px; vertical-align: top;"></canvas></div>
                              </div>
                              <p class="mt-lg">Hours</p>
                           </div>
                           <div class="col-xs-3 col-md-6 col-lg-3">
                              <div class="inline mv">
                                 <div data-sparkline="" values="30,70" data-type="pie" data-height="50" data-slice-colors="[&quot;#edf1f2&quot;, &quot;#f05050&quot;]" class="sparkline"><canvas width="50" height="50" style="display: inline-block; width: 50px; height: 50px; vertical-align: top;"></canvas></div>
                              </div>
                              <p class="mt-lg">Assigned</p>
                           </div>
                        </div>
                     </div>
                     <table class="table bb">
                        <tbody>
                           <tr>
                              <td>
                                 <strong>Assigned Hours</strong>
                              </td>
                              <td>68 hs</td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Time Consumed</strong>
                              </td>
                              <td>32 hs</td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Issues</strong>
                              </td>
                              <td>19</td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Bugs</strong>
                              </td>
                              <td>16</td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Health</strong>
                              </td>
                              <td>
                                 <em class="fa fa-smile-o fa-lg text-warning"></em>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Commits</strong>
                              </td>
                              <td>140</td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Recently closed</strong>
                              </td>
                              <td>
                                 <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 120px;"><div data-height="120" data-scrollable="" class="list-group" style="overflow: hidden; width: auto; height: 120px;">
                                    <table class="table table-bordered bg-transparent">
                                       <tbody>
                                          <tr>
                                             <td><a href="#" class="text-muted">BI:54678</a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><a href="#" class="text-muted">BI:55778</a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><a href="#" class="text-muted">BI:56878</a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><a href="#" class="text-muted">BI:57978</a>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><a href="#" class="text-muted">BI:1107</a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px; height: 75.3927px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
                              </td>
                           </tr>
                           <tr>
                              <td>
                                 <strong>Last closed on</strong>
                              </td>
                              <td>12/01/2016</td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <!-- end Aside panel-->
               </div>
               <div class="col-md-8">
                  <div class="mb-lg clearfix">
                     <div class="pull-left">
                        <button type="button" class="btn btn-sm btn-info">New ticket</button>
                        <button type="button" class="btn btn-sm btn-default">
                           <em class="fa fa-user-plus"></em>
                        </button>
                        <button type="button" class="btn btn-sm btn-default">
                           <em class="fa fa-pencil"></em>
                        </button>
                        <button type="button" class="btn btn-sm btn-default">
                           <em class="fa fa-mail-forward"></em>
                        </button>
                        <button type="button" class="btn btn-sm btn-default">
                           <em class="fa fa-print"></em>
                        </button>
                     </div>
                     <div class="pull-right">
                        <p class="mb0 mt-sm">19 bugs / 16 issues</p>
                     </div>
                  </div>
                  <div class="panel b">
                     <div class="panel-body">
                        <div class="table-responsive">
                           <div id="datatable1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="html5buttons"></div><div class="dataTables_length" id="datatable1_length"><label><select name="datatable1_length" aria-controls="datatable1" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> records per page</label></div><div id="datatable1_filter" class="dataTables_filter"><label>Search all columns:<input type="search" class="form-control input-sm" placeholder="" aria-controls="datatable1"></label></div><div class="dataTables_info" id="datatable1_info" role="status" aria-live="polite">Showing 1 to 10 of 35 entries</div><table id="datatable1" class="table dataTable no-footer" aria-describedby="datatable1_info" role="grid">
                              <thead>
                                 <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Type: activate to sort column descending" style="width: 30px;">Type</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="#ID: activate to sort column ascending" style="width: 29px;">#ID</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="Description: activate to sort column ascending" style="width: 254px;">Description</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="Created: activate to sort column ascending" style="width: 47px;">Created</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="Priority: activate to sort column ascending" style="width: 46px;">Priority</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="Asigned: activate to sort column ascending" style="width: 60px;">Asigned</th><th class="sorting" tabindex="0" aria-controls="datatable1" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending" style="width: 38px;">Status</th></tr>
                              </thead>
                              <tbody>
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                                 
                              <tr role="row" class="odd">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:54678</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>01/01/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Sylvia Daniels</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-success">open</div>
                                    </td>
                                 </tr><tr role="row" class="even">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:55778</td>
                                    <td class="text-nowrap">
                                       <small>Aliquam felis nibh, ultrices non elementum</small>
                                    </td>
                                    <td>01/05/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="low" class="circle circle-lg circle-gray" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Sherry Carroll</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-success">open</div>
                                    </td>
                                 </tr><tr role="row" class="odd">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:1107</td>
                                    <td class="text-nowrap">
                                       <small>Praesent lacinia ultricies neque.</small>
                                    </td>
                                    <td>01/01/2015</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="high" class="circle circle-lg circle-danger" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Warren Gray</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-danger">closed</div>
                                    </td>
                                 </tr><tr role="row" class="even">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:10127</td>
                                    <td class="text-nowrap">
                                       <small>Pellentesque habitant morbi tristique</small>
                                    </td>
                                    <td>05/02/2014</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Ernest Berry</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-danger">closed</div>
                                    </td>
                                 </tr><tr role="row" class="odd">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:54678</td>
                                    <td class="text-nowrap">
                                       <small>Integer venenatis ultrices vulputate.</small>
                                    </td>
                                    <td>01/01/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Sylvia Daniels</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-success">open</div>
                                    </td>
                                 </tr><tr role="row" class="even">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:56878</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>05/01/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Mitchell Jones</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-warning">pending</div>
                                    </td>
                                 </tr><tr role="row" class="odd">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:1107</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>01/01/2015</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="high" class="circle circle-lg circle-danger" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Warren Gray</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-danger">closed</div>
                                    </td>
                                 </tr><tr role="row" class="even">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:54678</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>01/01/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Sylvia Daniels</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-success">open</div>
                                    </td>
                                 </tr><tr role="row" class="odd">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:55778</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>01/05/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="low" class="circle circle-lg circle-gray" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Sherry Carroll</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-success">open</div>
                                    </td>
                                 </tr><tr role="row" class="even">
                                    <td class="sorting_1">
                                       <div class="badge bg-gray-lighter">bug</div>
                                    </td>
                                    <td>BI:56878</td>
                                    <td class="text-nowrap">
                                       <small>Maecenas mollis egestas convallis.</small>
                                    </td>
                                    <td>05/01/2016</td>
                                    <td>
                                       <div data-toggle="tooltip" data-title="normal" class="circle circle-lg circle-warning" data-original-title="" title=""></div>
                                    </td>
                                    <td><a href="#">Mitchell Jones</a>
                                    </td>
                                    <td>
                                       <div class="inline wd-xxs label label-warning">pending</div>
                                    </td>
                                 </tr></tbody>
                           </table><div class="dataTables_paginate paging_simple_numbers" id="datatable1_paginate"><ul class="pagination"><li class="paginate_button previous disabled" id="datatable1_previous"><a href="#" aria-controls="datatable1" data-dt-idx="0" tabindex="0">Previous</a></li><li class="paginate_button active"><a href="#" aria-controls="datatable1" data-dt-idx="1" tabindex="0">1</a></li><li class="paginate_button "><a href="#" aria-controls="datatable1" data-dt-idx="2" tabindex="0">2</a></li><li class="paginate_button "><a href="#" aria-controls="datatable1" data-dt-idx="3" tabindex="0">3</a></li><li class="paginate_button "><a href="#" aria-controls="datatable1" data-dt-idx="4" tabindex="0">4</a></li><li class="paginate_button next" id="datatable1_next"><a href="#" aria-controls="datatable1" data-dt-idx="5" tabindex="0">Next</a></li></ul></div></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</section>

{% endblock %}

{% block endofbody %}
<script src="{{ viewconf.assets }}vendor/sparkline/index.js"></script>
{% endblock %}