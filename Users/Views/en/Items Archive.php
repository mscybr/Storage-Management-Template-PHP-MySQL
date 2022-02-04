<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Log in </title>
</head>
<body>

<?php require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>


                <?php foreach ( $Items as $Item ) {  ?>
                    <div id="input_div" >
                        <br>
                        <itemid style="display : none;" item_id = "<?php echo $Item["Item_Id"] ?>"></itemid>
                        <label for="name">Item Name</label>
                        <input type="text" id="Item_Name" value = "<?php echo $Item["Item_Name"]; ?>">

                        <label for="name">Amount</label>
                        <input type="text" id="Amount" value = "<?php echo $Item["Amount"]; ?>">

                        <label >enter by : <?php echo $users[ $Item["Enter_User_Id"] ]; ?></label>
                        <b>|</b>
                        <label >exit by : <?php echo $users[ $Item["Exit_User_Id"] ]; ?></label>

                        
                        <?php if( $privs[  $_GET["storage_id"] ]["Item_Delete"] ){ ?>
                            <button id="delete_button" style="background: red;"> Delete item </button>
                        <?php }?>
                        

                        <br>
                    </div>

                <?php } ?>
                <?php if( $privs[  $_GET["storage_id"] ]["Item_Edit"] ){ ?>
                    <button id="submit_edit"> Save Changes </button>
                <?php }?>
               






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

                let item_id = div.querySelector("itemid").getAttribute("item_id")
                let new_name = div.querySelector("#Item_Name").value
                let amount = div.querySelector("#Amount").value

                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { 
                            update_item : item_id, 
                            name :  new_name,
                            amount : amount,

                        }) 
                    });

                let text = await fet.text();

                if( text == "1" ){

                    alert("updated item successfully")

                }
                
            }

        }

        async function delete_item ( item_id, button_id ){

            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { delete_item : item_id } ) });
            let text = await fet.text();
            if( text == "1" ){

                alert( "Deleted item successfully" );
                Delete_buttons[button_id].parentElement.remove()
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

                delete_item( button.parentElement.querySelector("itemid").getAttribute("item_id"), id )

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