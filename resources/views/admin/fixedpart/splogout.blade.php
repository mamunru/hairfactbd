<!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

   <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="{{url('admin/logout/final')}}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="GET" style="display: none;">
                                        @csrf
                                    </form>
        </div>
      </div>
    </div>
  </div>

   <!-- Bootstrap core JavaScript-->
  <script src="{{asset('AdminPanel/vendor')}}/jquery/jquery.min.js"></script>
  <script src="{{asset('AdminPanel/vendor')}}/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('AdminPanel/vendor')}}/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('AdminPanel/js')}}/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="{{asset('AdminPanel/vendor')}}/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('AdminPanel/js')}}/demo/chart-area-demo.js"></script>
  <script src="{{asset('AdminPanel/js')}}/demo/chart-pie-demo.js"></script>
