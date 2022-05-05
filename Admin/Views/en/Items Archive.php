<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">

    <title> Archive </title>
</head>
<body>
    
<?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>
    


<table class="table table-hover">
    <thead>
    <tr>
      <th scope="col">Item Name</th>
      <th scope="col">Amount</th>
      <th scope="col">Edit Name</th>
      <th scope="col">Edit Amount</th>
      <th scope="col">Enter By</th>
      <th scope="col">Exit By</th>
      <th scope="col">Delete Item</th>

    </tr>
  </thead>
  <tbody>
<div class="row mt-5">
 


                <?php 
                global $Items;
                global $users;

                foreach ( $Items as $Item ) {  ?>
                    <tr id="input_div"  item_id = "<?php echo $Item["Item_Id"] ?>">
                        <th class="table-warning" scope="row"><?php echo $Item["Item_Name"]; ?></th>

                        <td>
                            <?php echo $Item["Amount"]; ?>
                        </td>
                        
                        <td>
                            <input type="text" id="Item_Name" value = "<?php echo $Item["Item_Name"]; ?>">
                        </td>

                        <td>
                            <input type="text" id="Amount" value = "<?php echo $Item["Amount"]; ?>">
                        </td>
                        
                        <td>
                            <?php echo $users[ $Item["Enter_User_Id"] ]; ?>
                        </td>

                        <td>
                            <?php echo $users[ $Item["Exit_User_Id"] ]; ?>
                        </td>

                        <td>
                            <button class="btn btn-danger " id="delete_button" > Click </button>
                        </td>

                        <br>
                    </tr>

                <?php } ?>
                </tbody>
                </table>
                <button class="btn btn-danger mt-4" id="submit_edit"> Save Changes </button>






    <script>
        var Changes_Array = [];
        var Input_Elements = document.querySelectorAll("input");
        var Input_Divs = document.querySelectorAll("#input_div");
        var Delete_buttons = document.querySelectorAll("#delete_button")
        var Manage_buttons = document.querySelectorAll("#manage_button")
        var Submit_button = document.querySelector("#submit_edit")
        var Submit_add_button = document.querySelector("#sumbit_add")
        var add_item_name = document.querySelector("#Add_Item_Name")
        var add_item_amount = document.querySelector("#Add_Amount")


        async function Save_Changes(){

            for (let index = 0; index < Changes_Array.length; index++) {

                const div = Changes_Array[index];

                let item_id = div.parentElement.getAttribute("item_id")
                let new_name = div.parentElement.querySelector("#Item_Name").value
                let amount = div.parentElement.querySelector("#Amount").value

                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { 
                            update_item : item_id, 
                            name :  new_name,
                            amount : amount,

                        }) 
                    });

                let text = await fet.text();

                if( text == "1" ){

                    alert("updated successfully")
                    refresh();

                }else{
                    alert(text)
                    
                }
                
            }

        }

        function refresh (){
            window.location.assign( window.location.href )
        }

        async function delete_item ( item_id, button_id ){

            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { delete_item : item_id } ) });
            let text = await fet.text();
            if( text == "1" ){

                alert( "Deleted item successfully" );
                Delete_buttons[button_id].parentElement.parentElement.remove()
                Input_Divs = document.querySelectorAll("#input_div");

            }else{

                alert( text );

            }
        }


        async function add_item (  ) {
            
            if( add_item_name.value != "" && add_item_amount.value != "" ){

                let fet = await fetch( document.location.href, { method : "POST" , body : JSON.stringify( { add_item : add_item_name.value, amount : add_item_amount.value } )} );
                let text = await fet.text();

                if( text == "1" ){

                    alert( "added item successfully" );

                } else {

                    alert( text );

                }

            }

        }

        async function exit_item ( exit_id ) {

            let fet = await fetch( document.location.href, { method : "POST" , body : JSON.stringify( { exit_item : exit_id } )} );
            let text = await fet.text();

            if( text == "1" ){

                alert( "exited the item successfully" );

            } else {

                alert( text );

            }


        }


        function manage_storage( id ){

            window.location.assign( window.location.origin + "/Storage%20Management/Admin/Manage%20Storages.php?page=0&company_id="+id )

        }


        // setting up handlers

        Delete_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                delete_item( button.parentElement.parentElement.getAttribute("item_id"), id )

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
        Submit_add_button.onmousedown = add_item

    </script>



</body>
</html>
