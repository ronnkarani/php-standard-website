class Categories {
    static getCategories(start, limit){
        $.ajax({
          url: "../php/categories.php",
          method: "post",
          dataType: "text",
          data: {
            key: "get_categories",
            start: start,
            limit: limit,
          },
          success: function (response) {
              
            if (response != "no_more") {
              $("#categories-tbody").append(response);
              start += limit;
              Categories.getCategories(start, limit);
            } else {
              $("#categories-table").DataTable();
            }
            
          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            console.log(textStatus);

            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
              alert("Network Error!");
            } else {
              // something weird is happening
            }
          },
        });
    }

    static updateCategory(categoryid){
        $('#edit-category-name').val($("#category-"+categoryid).text());
        $("#categoryid").val(categoryid);
    }

    static updateCategorySubmit(){
        $("#edit-category-form").submit((e)=>{
            e.preventDefault();
            $.ajax({
                url: "../php/categories.php",
                method: "post",
                dataType: "text",
                data: {
                    key: "update_category",
                    categoryid: $("#categoryid").val() ,
                    categoryname: $("#edit-category-name").val(),
                },
                beforeSend: () => {
                    $("#edit-category-result").removeClass("text-danger");
                    $("#edit-category-result").removeClass("text-success");
                    $("#edit-category-result").addClass("text-primary");
                    $("#edit-category-result").text("Updating category");
                },
                success: function (response) {
                    $("#edit-category-result").removeClass("text-primary");
                    if(response == 'updated'){
                        $("#edit-category-result").removeClass("text-danger");
                        $("#edit-category-result").addClass("text-success");
                        $("#edit-category-result").text("category updated successfully");
                        $("#categories-tbody").html('');
                        Categories.getCategories(0, 10);
                    }else if(response == 'exist'){
                        $("#edit-category-result").removeClass("text-success");
                        $("#edit-category-result").addClass("text-danger");
                        $("#edit-category-result").text("category name exist");
                    }else{
                        $("#edit-category-result").removeClass("text-success");
                        $("#edit-category-result").addClass("text-danger");
                        $("#edit-category-result").text("error while updating category");
                    }
                },
                error: (XMLHttpRequest, textStatus, errorThrown) => {
                    console.log(textStatus);

                    if (XMLHttpRequest.readyState == 4) {
                    // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                    } else if (XMLHttpRequest.readyState == 0) {
                    // Network error (i.e. connection refused, access denied due to CORS, etc.)
                    alert("Network Error!");
                    } else {
                    // something weird is happening
                    }
                },
            });
        });
        
    }

    static deleteCategory(categoryid){
        console.log(categoryid);
        $("#delete-category-form").submit(function (e) {
        e.preventDefault();
        $.ajax({
          type: "post",
          url: "../php/categories.php",
          data: {
            key: "delete_category",
            categoryid: categoryid,
          },
          dataType: "text",
          success: (response) => {
            $("#deleteModal").modal("hide");
            if(response === 'category_deleted'){
              $(".success-modal-text").text('Category deleted successfully.');
              $("#successModal").modal("show");
              $('#row-'+categoryid).remove();
              return;
            }else if(response === 'failed'){
                $("#successModal").modal("hide");
              alert('Failed to delete category');
              return;
            }
            else if(response === 'in_use'){
                $("#successModal").modal("hide");
              alert('Error! Posts under this category exist.');
              return;
            }
            else{
              alert('Error while deleting category');
              console.log('response');
              return;
            }
          },
          error: (XMLHttpRequest, textStatus, errorThrown) => {
            console.log(textStatus);

            if (XMLHttpRequest.readyState == 4) {
              // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
            } else if (XMLHttpRequest.readyState == 0) {
              // Network error (i.e. connection refused, access denied due to CORS, etc.)
              alert("Network Error!");
            } else {
              // something weird is happening
            }
          },
        });
      });
    }

    static addCategory(){
        $("#add-category-form").submit((e)=>{
            e.preventDefault();
            $.ajax({
                url: "../php/categories.php",
                method: "post",
                dataType: "text",
                data: {
                    key: "add_category",
                    categoryname: $("#add-category-name").val(),
                },
                beforeSend: () => {
                    $("#add-category-result").removeClass("text-danger");
                    $("#add-category-result").removeClass("text-success");
                    $("#add-category-result").addClass("text-primary");
                    $("#add-category-result").text("adding category");
                },
                success: function (response) {
                    $("#add-category-result").removeClass("text-primary");
                    if(response == 'category_added'){
                        $("#add-category-result").removeClass("text-danger");
                        $("#add-category-result").addClass("text-success");
                        $("#add-category-result").text("category added successfully");
                        $("#addCategoryModal").modal('hide');
                        $("#categories-tbody").html('');
                        Categories.getCategories(0, 10);
                    }else if(response == 'exist'){
                        $("#add-category-result").removeClass("text-success");
                        $("#add-category-result").addClass("text-danger");
                        $("#add-category-result").text("category name exist");
                    }else{
                        console.log(response);
                        $("#add-category-result").removeClass("text-success");
                        $("#add-category-result").addClass("text-danger");
                        $("#add-category-result").text("error while adding category");
                    }
                },
                error: (XMLHttpRequest, textStatus, errorThrown) => {
                    console.log(textStatus);

                    if (XMLHttpRequest.readyState == 4) {
                    // HTTP error (can be checked by XMLHttpRequest.status and XMLHttpRequest.statusText)
                    } else if (XMLHttpRequest.readyState == 0) {
                    // Network error (i.e. connection refused, access denied due to CORS, etc.)
                    alert("Network Error!");
                    } else {
                    // something weird is happening
                    }
                },
            });
        });
    }
}


window.addEventListener("DOMContentLoaded", () => {
Categories.getCategories(0, 10);
Categories.addCategory();
Categories.updateCategorySubmit();

$("#showAddModalBtn").click(()=>{
    $("#add-category-result").html('');
    $("#add-category-name").val('');
})

$("#categories-tbody").click(function (e) {
    e.preventDefault();
    if ($(e.target.parentElement).hasClass("edit")) {

      Categories.updateCategory(e.target.parentElement.dataset.categoryid);
    }
  });
  $("#editModal").on("hide.bs.modal", function () {
    console.log('hiding');
    
    document.getElementById("edit-category-form").reset();
    $("#edit-category-result").html('');
  });
})