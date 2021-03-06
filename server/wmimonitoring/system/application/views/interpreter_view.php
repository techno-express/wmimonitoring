    <script type="text/javascript">
        dojo.require("dijit.Dialog");
        dojo.require("dijit.form.ValidationTextBox");
        dojo.require("dijit.form.Button");
        dojo.require("dijit.form.Form");
		var iddata;
        function showupdate(id){
            dijit.byId("dialog1").show();
            dijit.byId("buttondialog").attr("label", "Update");
            var xhrargs={
                url: "<?=site_url("interpreter_program/databyid")?>/"+id,
                handleAs:"json",
                preventCache:false,
                load: function(data){
                    dijit.byId("name").attr("value", data['name']);
                    dijit.byId("command").attr("value", data['command']);
                    iddata=data['id'];
                    dojo.byId("loadingdialog").innerHTML="";
                },
                error: function(error){
                    dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
                }
            }
            dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrGet(xhrargs);
        }
        function updatetable(){
            self.frames["gridshow"].refreshgrid();
            //self.frames["gridshow"].window.location.href="<?=site_url("registry_setting/show_grid")?>";
        }
        function updatedata(id){
            var xhrargs={
                url: "<?=site_url("interpreter_program/update")?>/"+id,
                handleAs:"text",
                form:dojo.byId("formregistry"),
                load: function(data){
                    if(data=="true"){
                        dojo.byId("loadingdialog").innerHTML="";
                        iddata="";
                        dijit.byId("dialog1").hide();
                        updatetable();
                    }
                    else{
                        dojo.byId("loadingdialog").innerHTML=data;
                    }
                },
                error: function(error){
                    dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
                }
            }
            dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrPost(xhrargs);
        }
        function deletedata(id){
            if(confirm("Are you sure to Delete this data "+id)){
                var xhrargs={
                    url: "<?=site_url("interpreter_program/delete")?>/"+id,
                    handleAs:"text",
                    preventCache:false,
                    load: function(data){
                        if(data=="true"){
                            dojo.byId("loading").innerHTML="";
                        }
                        else{
                            dojo.byId("loading").innerHTML=data;
                        }
                        updatetable();
                    },
                    error: function(error){
                        dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                    }
                };
                dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                var senddata=dojo.xhrGet(xhrargs);
            }
        }
        function showadd(){
            dijit.byId("name").attr("value", "");
            dijit.byId("command").attr("value", "");
            dijit.byId("buttondialog").attr("Label", "Save");
            dijit.byId("dialog1").show();
            dojo.byId("loadingdialog").innerHTML="";
        }
        function adddata(){
            var xhrargs={
                url: "<?=site_url("interpreter_program/add")?>",
                handleAs:"text",
                form:dojo.byId("formregistry"),
                load: function(data){
                    if(data=="true"){
                        dojo.byId("loadingdialog").innerHTML="";
                        dijit.byId("dialog1").hide();
                        updatetable();
                    }
                    else{
                        dojo.byId("loadingdialog").innerHTML=data;
                    }
                },
                error: function(error){
                    dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
                }
            }
            dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrPost(xhrargs);
        }
    </script>
            <div id="content">
                <div id="loading"></div>
                <iframe src="<?=site_url("interpreter_program/showgrid")?>" frameborder="0" height="250" width="775" id="gridshow" name="gridshow"></iframe><br>
                <center>
                    <button dojoType="dijit.form.Button" id="buttonadd" label="Insert New" style="color:black" iconClass="dijitEditorIcon dijitEditorIconInsertTable">
                        <script type="dojo/method" event="onClick">
                            showadd();
                        </script>
                    </button>
                </center>
            </div>
          	<div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>    
    <div dojoType="dijit.Dialog" id="dialog1" title="Computer Profile" draggable="false">
    <div id="loadingdialog" style="color:black"></div>
    <form id="formregistry" dojoType="dijit.form.Form">
        <table border="0">
            <tbody>
                <tr>
                    <td><label for="name" style="color:black">Name</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="name" id="name" style="color:black" required="true" lowercase="true" trim="true"></td>
                </tr>
                <tr>
                <tr>
                    <td><label for="command" style="color:black">Command Text</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="command" id="command" style="color:black" required="true" trim="true"></td>
                </tr>
                <tr>
                    <td colspan="2"><button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                        <script type="dojo/method" event="onClick">
                            if(dijit.byId("formregistry").validate()){
                                if(this.label=="Save")
                                    adddata();
                                else
                                    updatedata(iddata);
                            }
                        </script>
                    </button></td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>
</body>
</html>
