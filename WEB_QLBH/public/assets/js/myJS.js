//Begin Model 
function addImg()
{
    var fileInput  = document.getElementById('fileInput');
    fileInput.click();
    var  avatar = document.getElementById('img');
    var  frameAvatar =document.getElementsByClassName('frame');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            console.log(file.name);
            frameAvatar[0].classList.add('d-none');
            frameAvatar[1].classList.remove('d-none');
            avatar.src = URL.createObjectURL(file);
        }
    });
}

function addData()
{
    var formAddData = document.getElementById('addData');
    formAddData.submit()
}

function showModel()
{
    var backdrop = document.getElementsByClassName("backdrop");
    var addRowModal = document.getElementById("addRowModal");
    // Hiển thị/ ẩn form
    document.body.classList.toggle('no-scroll'); // cố định form
    backdrop[0].classList.toggle('d-block'); 
    addRowModal.classList.toggle('d-block');
}

//End Model

//Actions model
    //  Xoá dữ liệu

function removeData(id)
{
    let formRemoveData = document.getElementById('removeData');
    let routeDelete = formRemoveData.getAttribute('action')

    formRemoveData.setAttribute('action',routeDelete + "/" + id);
    formRemoveData.submit()
}

var btnDelete = document.querySelectorAll('.btn-delete');

btnDelete.forEach(function(btn){
    btn.addEventListener('click',function(){
        let id = btn.getAttribute('data-id');
        removeData(id);
    })
});

//
