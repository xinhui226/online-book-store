<div class="col-md-10 d-flex justify-content-end">
<form 
            class="d-flex" 
            method="POST" 
            action="<?=$_SERVER['REQUEST_URI']; ?>">
                <input 
                class="form-control rounded-5"
                type="search"
                name="search"
                placeholder="Search" 
                aria-label="Search">
                <button 
                class="border-0 colordark searchbtn ms-1 position-relative" 
                type="submit">
                <i class="bi bi-search position-absolute translate-middle"></i>
                </button>
            </form>
</div>