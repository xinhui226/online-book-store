</div>
    </div>
  </div>
  </div>
</div>
<div class="text-muted small fixed-bottom">
          © 2022 <a href="/" class="text-muted">Book Store</a>
        </div>

<!-- toast message -->
<script>  

    const toastbox = document.getElementById('myToast')
if (toastbox) {
  document.addEventListener('DOMContentLoaded', function() {
    const toast = new bootstrap.Toast(toastbox)
    toast.show()
  })
}
</script>

<!-- password visualization -->
<script>
    let password = document.getElementById('password');
    let icon = document.getElementById('icon');
    let confirmpw = document.getElementById('confirm_password');
    let icon2 = document.getElementById('icon2');

    icon.onclick = function(){
        let type=password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type',type);

        this.classList.toggle('bi-eye');
    }
    icon2.onclick = function(){
        let type=confirmpw.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmpw.setAttribute('type',type);

        this.classList.toggle('bi-eye');
    }
</script>

<!-- active navbar -->
<script>
  let links = document.getElementsByClassName('nav-link'); 
  let activePage = window.location.pathname;

  for (let i = 0; i < links.length; i++) {
     if(links[i].href.includes(`${activePage}`)){
       links[i].classList.add('active'); 
       } 
  }
</script>

<!-- select 2(plugin) -->
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.category-multipleselect').select2({
      placeholder:"--Select--"
    });
});
</script>

<!-- bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>