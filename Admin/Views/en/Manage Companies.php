<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">
    <title> Manage Companies </title>
</head>
<body>
                <?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>

            <div class="row mt-5">
        <div class="col-md-7 m-auto">
        <div class="card text-white bg-dark card-body m-auto" style="max-width: 50rem;">
                <h1 class= "m-auto text-warning"> Add Company </h1>
                <br>
                <label class="col-form-label" for="name">Company Name</label>
                <input  class="form-control" type="text" id="Add_Company_Name" >

                <label class="col-form-label" for="name">Company Thumbnail</label>
                <input  class="form-control" type="text" id="Add_Company_Thumbnail" >
                <button class="btn btn-danger mt-4"  id="sumbit_add"> Add </button>
        </div>


    <table class="table table-hover">
        <thead>
        <tr>
        <th scope="col">Company Name</th>
        <th scope="col">Update Company Name</th>
        <th scope="col">Update Company Image Link</th>
        <th scope="col">Manage Storages</th>
        <th scope="col">Delete Company</th>


        </tr>
    </thead>
    <tbody>
    <?php 
    global $companies;
    
    foreach ( $companies as $company ) {  ?>
            <tr id="input_div"  name ="<?php echo $company["Company_Name"]; ?>">
   
                <th class="table-warning"><?php echo $company["Company_Name"]; ?></th>

                <td >
                    <input type="text" id="Company_Name" value = "<?php echo $company["Company_Name"]; ?>">
                </td>

                <td >
                    <input type="text" id="Company_Thumbnail" value = "<?php echo $company["Company_Thumbnail"]; ?>">
                </td>

                <td>
                    <button id="manage_button" class="btn btn-lg btn-outline-info" company_id ="<?php echo $company["Company_Id"]; ?>" > Click </button>
                </td>

                <td>
                    <button id="delete_button" class="btn btn-lg btn-outline-warning"> Click </button>
                </td>

        </tr>

    <?php } ?>
    </tbody>
    </table>
    <button class="btn btn-lg btn-dark mt-4" id="submit_edit"> Save Changes </button>

    </div>
    </div>






    <script>
        var Changes_Array = [];
        var Input_Elements = document.querySelectorAll("input");
        var Input_Divs = document.querySelectorAll("#input_div");
        var Delete_buttons = document.querySelectorAll("#delete_button")
        var Manage_buttons = document.querySelectorAll("#manage_button")
        var Submit_button = document.querySelector("#submit_edit")
        var Submit_add_button = document.querySelector("#sumbit_add")
        var add_company_name = document.querySelector("#Add_Company_Name")
        var add_company_thumbnail = document.querySelector("#Add_Company_Thumbnail")


        async function Save_Changes(){

            for (let index = 0; index < Changes_Array.length; index++) {

                const div = Changes_Array[index].parentElement;

                let old_name = div.getAttribute("name")
                let new_name = div.querySelector("#Company_Name").value
                let new_thumbnail = div.querySelector("#Company_Thumbnail").value

                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { 

                            update_old_name : old_name, 
                            update_name :  new_name,
                            update_thumbnail : new_thumbnail,

                        }) 
                    });

                let text = await fet.text();

                refresh();
                
            }

        }

        async function delete_company ( company, button_id ){

            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { delete_company : company } ) });
            let text = await fet.text();
            refresh();
        }


        async function add_company (  ){
            
            if( add_company_name.value != "" && add_company_thumbnail.value != "" ){

                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { add_company : add_company_name.value, company_thumbnail : add_company_thumbnail.value } ) });
                let text = await fet.text();

                refresh();

            }
        }

        function refresh (){
            alert("updated")
            window.location.assign( window.location.href )
        }


        function manage_storage( id ){

            window.location.assign( window.location.origin + "/Admin/Manage%20Storages.php?page=0&company_id="+id )
            
        }


        // setting up handlers

        Delete_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                delete_company( button.parentElement.parentElement.getAttribute("name"), id )

            }
        })
        
        Manage_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                manage_storage( button.getAttribute("company_id") )

            }
        })

        Input_Elements.forEach( ( element, indx ) =>{

            element.onchange = ()=>{

                if( Changes_Array.find( el=> el == element.parentElement ) == undefined ){
                    Changes_Array.push(element.parentElement);
                }

            }
            
        })

        Submit_button.onmousedown = Save_Changes
        Submit_add_button.onmousedown = add_company

    </script>



</body>
</html>
