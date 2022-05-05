<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://bootswatch.com/5/lux/bootstrap.min.css" rel="stylesheet">
    <title> Manage Storages </title>
</head>
<body>
    <?php 
    global $Storages;
    require_once $_SERVER['DOCUMENT_ROOT']."/assets/html/nav bar.php"; ?>

            <div class="row mt-5">
            <div class="col-md-7 m-auto">
            <div class="card text-white border-primary bg-dark card-body m-auto" style="max-width: 50rem;">
                <h1 class = "m-auto text-info"> Add Storage </h1>
                <button class="btn btn-danger  mt-4" id="sumbit_add"> Add </button>

    <?php foreach ( $Storages as $Storage ) {  ?>

            <div id="input_div" class=" mt-4" >
                <id style="visibility : hidden" storage_id = "<?php echo $Storage["Storage_Id"] ?>"> </id>
                <b> Id : <?php echo $Storage["Storage_Id"] ?> </b>
                <button id="manage_button" class="btn btn-primary" storage_id = "<?php echo $Storage["Storage_Id"] ?>" > Manage Items </button>
                <button id="archive_button" class="btn btn-info" storage_id = "<?php echo $Storage["Storage_Id"] ?>"> Storage Archive </button>
                <button id="delete_button" class="btn btn-danger"> Delete Storage </button>

                <br>
            </div>

    <?php } ?>






    <script>

        var Input_Divs = document.querySelectorAll("#input_div");
        var Manage_buttons = document.querySelectorAll("#manage_button")
        var Archive_buttons = document.querySelectorAll("#archive_button")
        var Delete_buttons = document.querySelectorAll("#delete_button")
        var Submit_add_button = document.querySelector("#sumbit_add")



        async function delete_storage ( storage_id, button_id ){

            let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify( { delete_storage : storage_id } ) });
            let text = await fet.text();
            refresh();
        }


        function manage_items( id ){
            window.location.assign( window.location.origin + "/Admin/Manage%20Items.php?page=0&storage_id="+id )
        }

        function archive( id ){
            window.location.assign( window.location.origin + "/Admin/Items%20Archive.php?page=0&storage_id="+id )
        }
        
        function refresh (){
            alert("updated")
            window.location.href = "" 
        }
        

        async function add_storage (  ){
            


                let fet = await fetch(document.location.href, { method : "POST" , body : JSON.stringify({ add_storage: "" }) } );
                let text = await fet.text();

                refresh();

            
        }

        Manage_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                manage_items( button.getAttribute("storage_id") )

            }
        })
    
        Archive_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                archive( button.getAttribute("storage_id") )

            }
        })


        // setting up handlers

        Delete_buttons.forEach( ( button, id ) =>{

            button.onmousedown = () =>{

                delete_storage( button.parentElement.querySelector("id").getAttribute("storage_id"), id )

            }
        })



        Submit_add_button.onmousedown = add_storage

    </script>



</body>
</html>
