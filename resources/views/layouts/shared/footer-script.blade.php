<!-- bundle -->
<!-- Vendor js -->
<script src="{{asset('assets/js/vendor.min.js')}}"></script>
@yield('script')
<!-- App js -->
<script src="{{asset('assets/js/app.min.js')}}"></script>
<script>
function updateBranchName() {
    // Get the selected option element
    const branchSelect = document.getElementById("branch");
    const selectedOption = branchSelect.options[branchSelect.selectedIndex];

    // Get the branch name and address
    const branchName = selectedOption.text;
    const branchAddress = selectedOption.getAttribute("data-value");

    // Set the branch name and address in the respective hidden input fields
    document.getElementById("branchname").value = branchName;
    document.getElementById("branchaddress").value = branchAddress;
}


</script>
@yield('script-bottom')
