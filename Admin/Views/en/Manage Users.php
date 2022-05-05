<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">
    <title> Manage Users </title>
</head>
<body>
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>


    <div class="row mt-5">
        <div class="col-md-7 m-auto">
        <div class="card text-white bg-dark card-body m-auto" style="max-width: 50rem;">
                <h1 class= "m-auto text-success"> Add User </h1>
                <br>
                <label class="col-form-label" for="name">Name</label>
                <input class="form-control" type="text" id="Add_Name" >

                <label class="col-form-label" for="name">Password</label>
                <input class="form-control" type="text" id="Add_Password" >
                <button class="btn btn-danger mt-4"  id="sumbit_add"> Add </button>
                <br>
        </div>
        </div>
     </div>

     <br>
    <table class="table table-warning">
    <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Password</th>
      <th scope="col">Update Name</th>
      <th scope="col">Update Password</th>
      <th scope="col">Select Company</th>
      <th scope="col">Select Storage</th>
      <th scope="col">Add Privilege</th>
      <th scope="col">Delete User</th>




    </tr>
  </thead>
  <tbody>
        <?php 
        global $users;
        global $companies;
        global $privilages;
        global $storages;
        
        foreach ( $users as $user ) {  ?>

                <tr id="input_div"class="table-active" old_name="<?php echo $user["Name"]; ?>" User_Id = "<?php echo $user["User_Id"]; ?>" >

                    <th scope="row"><?php echo $user["Name"]; ?></th>
                    <td><?php echo $user["Password"]; ?></td>
                    <td> <input type="text" id="name" value = "<?php echo $user["Name"]; ?>"> </td>
                    <td><input type="text" id="password" value = "<?php echo $user["Password"]; ?>"></td>
                    <td>
                            <select class="form-select" id="select_company">
                                <?php foreach ( $companies as $company ) {  ?>
                                    <option > <?php echo $company["Company_Name"]?> </option>
                                <?php } ?>
                            </select>
                            </td>
                            <td>
                                <select class="form-select" id="select_storage"></select>
                            </td>

                            <td>
                            <!-- <input type="checkbox" adder = "true" id="enter_previlage">
                            <input type="checkbox" adder = "true" id="exit_previlage">
                            <input type="checkbox" adder = "true" id="edit_previlage">
                            <input type="checkbox" adder = "true" id="delete_previlage"> -->
                                <button class ="btn btn-secondary mt-4" id="sumbit_add_priv"> Add Privilage</button>
                            </td>

                    <td> <button class ="btn btn-danger mt-4" id="delete_button" > Delete user </button> </td>
                    </tr>

                <?php } ?>
                



                    
        </tbody>
    </table>



    <table class="table table-warning">
    <thead>
        <tr>
        <th scope="col">User</th>
        <th scope="col">Storage Id</th>
        <th scope="col">Enter</th>
        <th scope="col">Exit</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>



        </tr>
    </thead>
    <tbody>


    <?php foreach ( $users as $user ) {  ?>
            <!-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Edit</button> -->
            <?php if( isset( $privilages[$user["User_Id"]][0] ) ){ ?>
            <?php foreach ( $privilages[$user["User_Id"]][0] as $privilage ) {  ?>
                <tr id="priv_div" user_id="<?php echo $user["User_Id"]?>"storage_id="<?php echo $privilage['Storage_Id'];?>">
                <th>  <?php echo $user["Name"]?> </th>

                    <td><?php echo $privilage['Storage_Id'];?></td>
                    <td>
                        <input class="form-check-input flex-shrink-0" type="checkbox" value = "<?php var_dump($privilage["Item_Enter"]) ?>" id="enter_previlage">
                    </td>
                    <td>
                        <input class="form-check-input flex-shrink-0" type="checkbox" value = "<?php var_dump($privilage["Item_Exit"]) ?>" id="exit_previlage">
                    </td>

                    <td>
                        <input class="form-check-input flex-shrink-0" type="checkbox" value = "<?php var_dump($privilage["Item_Edit"]) ?>" id="edit_previlage">
                    </td>

                    <td>
                        <input class="form-check-input flex-shrink-0" type="checkbox" value = "<?php var_dump($privilage["Item_Delete"]) ?>" id="delete_previlage">
                    </td>


            </tr>
            <?php }} ?>
            <?php } ?>

    </tbody>
    </table>


            <button  class ="btn btn-primary mt-4" id="submit_edit"> Save Updates </button>





    <script>
        var storages = <?php echo $storages ?> 
        var company_ids_by_storage_id = {};
        var selects = document.querySelectorAll("select")
        var selects_companies = Array.prototype.filter.call( document.querySelectorAll("select"), element => element.id == "select_company" )
        var Changes_Array = [];
        var Input_Elements = Array.prototype.filter.call( document.querySelectorAll("input"), element =>  element.id != "Add_Name" && element.id != "Add_Password" ); 
        var Input_Divs = document.querySelectorAll("#input_div");
        var Delete_User_Buttons = document.querySelectorAll("#delete_button")
        var Submit_button = document.querySelector("#submit_edit")
        var Add_Name = document.querySelector("#Add_Name")
        var Add_Password = document.querySelector("#Add_Password")
        var sumbit_add = document.querySelector("#sumbit_add")
        var sumbit_add_priv = document.querySelectorAll("#sumbit_add_priv")
        var checkboxes = Array.prototype.filter.call( document.querySelectorAll("input"), element => element.type == "checkbox" && element.value != "on")


        function refresh (){
            alert("updated")
            window.location.href = "" 
        }
        


        async function add_user (  ){
            
            if( Add_Name.value != "" && Add_Password.value != "" ){

                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { add_user : Add_Name.value, password : Add_Password.value } ) });
                let text = await fet.text();

                if( text == "1" ){

                    refresh();
                    // alert( "added company successfully" );

                }else{

                    alert( text );

                }

            }
        }


        async function add_privilege ( button ){

             div = button.parentElement.parentElement

            // 0 = enter privilege, 1 = exit, 2 = edit
             checkboxes2 = [ 0, 0, 0, 0]//Array.prototype.filter.call( div.querySelectorAll("input"), element => element.getAttribute("adder") == "true").map( priv=> priv.checked == true ? 1 : 0 )
             storage_id = div.querySelector("#select_storage").value
            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { add_privilege : div.getAttribute("User_id"), storage_id : storage_id, enter : checkboxes2[0], exit : checkboxes2[1], edit : checkboxes2[2] , delete : checkboxes2[3] } ) });
            let text = await fet.text();

            if( text == "1" ){

                // alert( "added privilege" );
                refresh();

            }else  if( text == "2" ){

                // alert( "updated privilege" );
                refresh();

            }else{

                // alert( text );
                refresh();
                

            }

        }


        async function Save_Changes(){

            Refresh = false
            for (let index = 0; index < Changes_Array.length; index++) {
                var div = Changes_Array[index];
                if( div.parentElement.id != "priv_div"){

                    let old_name = div.parentElement.getAttribute("old_name")
                    let new_name = div.parentElement.querySelector("#name").value
                    let new_password = div.parentElement.querySelector("#password").value

                    let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( {
                         
                                update_old_name : old_name, 
                                update_name :  new_name,
                                update_password : new_password

                            }) 
                        });
                    let text = await fet.text();
                    Refresh = true

                }else{

                    div = div.parentElement
                    let enter_prev = div.querySelector("#enter_previlage").checked == true ? 1 : 0
                    let exit_prev = div.querySelector("#exit_previlage").checked == true ? 1 : 0
                    let edit_prev = div.querySelector("#edit_previlage").checked == true ? 1 : 0
                    let delete_prev = div.querySelector("#delete_previlage").checked == true ? 1 : 0
                    let storage_id = div.getAttribute("storage_id")
                    let user_id = div.getAttribute("user_id")

                    let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { 
                                add_privilege : user_id, 
                                storage_id :  storage_id,
                                enter : enter_prev,
                                edit : edit_prev,
                                exit : exit_prev,
                                delete : delete_prev
                            }) 
                        });
                    let text = await fet.text();
                    Refresh = true



                }
                
            }
            if (Refresh) {
                refresh()
            }

        }

        async function delete_user( user, button_id ){

            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { delete_user : user } ) });
            let text = await fet.text();
            if( text == "1" ){

                // alert( "Deleted user successfully" );
                // Delete_User_Buttons[button_id].parentElement.remove()
                // Input_Divs = document.querySelectorAll("#input_div");
                refresh();

            }else{

                alert( text );

            }
        }

        function find_element_index ( HTML_Array, Matching_Element ){
            let indx = null;
            HTML_Array.forEach( ( Element, Index )=>{
                if( Element == Matching_Element ){
                    indx = Index;
                }

            })
            return indx;
        }

        function refresh_storages(){

            selects.forEach( select => {
                if( select.id == "select_storage" ){
                    select.innerHTML = ""
                    storages[ select.parentElement.parentElement.querySelector("#select_company").value ].forEach(element => {
                    select.innerHTML += `<option company_id = "${element.Company_Id}"         value="${element.Storage_Id}">${element.Storage_Id}</option>`
                });
                }
            });
            


        }


        // setting up handlers

        Delete_User_Buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                delete_user( button.parentElement.parentElement.getAttribute("user_id"), id )

            }
        })


        Input_Elements.forEach( ( element, indx ) =>{

            element.onchange = ()=>{
                if( Changes_Array.find( el=> el == element.parentElement ) == undefined ){
                    Changes_Array.push(element.parentElement);
                }
            }

        })

        checkboxes.forEach( element => {

            if ( Number(/\d/.exec(element.value)[0]) == 1){

                element.checked = true

            }else{

                element.checked = false

            }
            
        });

        selects_companies.forEach ( select => {
            select.onchange = refresh_storages
            refresh_storages()
        }); 
        

        sumbit_add.onmousedown = add_user
        sumbit_add_priv.forEach( button => {
            button.onmousedown = ()=> add_privilege(button)
        });

        Submit_button.onmousedown = Save_Changes


        for ( var storage in storages ){
            storages[storage].forEach( strg => company_ids_by_storage_id[ strg["Storage_Id"] ] = strg["Company_Id"]  )
        }

        function refresh (){
            window.location.assign( window.location.href )
        }
        

    </script>



</body>
</html>
