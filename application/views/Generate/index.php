<script type="text/javascript">
    setTimeout("loadingAjax()",3000);
    function loadingAjax(){
        $(document).ready(function(){
            $.ajaxSetup ({
                global: false,
                cache: false,
                async: false
            });
            $.ajax({
                url: "generate_xml_data",
                data: "ident=<?php echo $ident; ?>&apikey=<?php echo $apikey; ?>&basecampUrl=<?php echo $basecampUrl; ?>&from=reg",
                type: "POST",
                success: function(html){
                    $(".resultXmlTxt").html(html);
                }
            });
        });
    }
</script>
<section class="resultXml">
    <img src="<?php echo base_url(); ?>images/homepage/image1.png" />
    <div class="resultXmlTxt">
        <img src='<?php echo base_url(); ?>images/dashboard/load.gif' alt='loading...' />
        <p>Loading up your Basecamp projects...</p>
        <p>Please Wait.</p>
    </div>
</section>