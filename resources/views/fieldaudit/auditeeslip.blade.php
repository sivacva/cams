@section('content')
    @extends('index2')

    @include('common.alert')

    <?php

    $instdel = json_decode($inst_details, true);

    if (count($instdel)) {
        $auditscheduleid = $instdel[0]['auditscheduleid'];
        $schteammemberid = $instdel[0]['schteammemberid'];
        $auditplanid = $instdel[0]['auditplanid'];
        $instid = $instdel[0]['instid'];
        $teamheaduserid = $teamheadid;
    } else {
        $auditscheduleid = '';
        $schteammemberid = '';
        $auditplanid = '';
        $instid = '';
        $teamheaduserid = '';
    }

    ?>

    <link rel="stylesheet" href="../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../assets/libs/daterangepicker/daterangepicker.css">

    <style>
        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            min-height: 200px;
        }

        .ck-editor__editable {
            font-family: 'Marutham', sans-serif;
        }

        .content-cell {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            /* Show only 2 lines */
            overflow: hidden;
            text-overflow: ellipsis;
            height: 40px;
            /* Adjust this based on your line height */
            line-height: 20px;
            /* Set this to match your text height */
            white-space: normal;
            /* Allow wrapping */
        }

        /* @font-face {
                                                                                                                                                                                                                                 font-family: 'Marutham';
                                                                                                                                                                                                                            src: url('path/to/marutham.ttf') format('truetype');
                                                                                                                                                                                                                       } */

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        .card-body {
            padding: 15px 10px;
        }

        .card {
            margin-bottom: 10px;
        }

        /* Step Circle Style */
        .step-circle {
            display: inline-block;
            width: 25px;
            height: 25px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            background-color: #fff;
            color: #0d6efd;
            font-weight: bold;
            /* position: absolute; */
            top: -10px;
            left: 10px;
            font-size: 14px;
            border: 2px solid #0d6efd;
        }

        /* Mobile View Adjustments */
        @media (max-width: 768px) {

            /* Make the navigation stack vertically on smaller screens */
            .nav-pills .nav-item {
                width: 100%;
                text-align: left;
                margin-bottom: 10px;
            }

            /* Adjust the .nav-link to display block on mobile */
            .nav-pills .nav-link {
                display: block;
                padding-left: 40px;
                /* Ensure the text doesn't overlap with the circle */
            }

            /* Adjust the circle position and size */
            .step-circle {
                position: relative;
                top: 0;
                left: 0;
                margin-right: 10px;
                font-size: 16px;
                display: inline-block;
            }

            /* Adjust the tab content for smaller screens */
            .tab-content {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Make the 3rd and 4th steps appear in separate rows */
            .tab-content .row {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
            }

            .tab-pane .col-md-6 {
                width: 100%;
            }
        }

        /* Small screens, stack elements even more */
        @media (max-width: 576px) {
            .nav-pills .nav-item {
                width: 100%;
                text-align: left;
            }

            .nav-pills .nav-link {
                display: flex;
                align-items: center;
                padding-left: 40px;
                /* Keeps the circle alignment */
            }

            .step-circle {
                margin-right: 10px;
                font-size: 18px;
                top: 0;
                left: 0;
                display: inline-block;
            }

            /* Adjust the tab content padding for small screens */
            .tab-content {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Adjust rows in tab content to display properly on mobile */
            .tab-pane .row {
                display: flex;
                flex-direction: column;
            }

            .tab-pane .col-md-6 {
                width: 100%;
                /* Ensure full width for each column */
            }
        }

        /* For larger screens, keep the default horizontal nav-pills layout */
        @media (min-width: 992px) {
            .nav-pills .nav-item {
                width: auto;
                /* Revert the width to auto for large screens */
            }

            .nav-pills .nav-link {
                display: inline-block;
                /* Horizontal layout */
            }

            .step-circle {
                margin-right: 10px;
                font-size: 16px;
                top: -10px;
                left: 10px;
            }
        }


        .wizard .nav-link {
            font-weight: bold;
            border: 1px solid #dee2e6;
            margin: 0 5px;
            border-radius: 5px;
        }

        .wizard .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
    <?php 

if (count($instdel)) 
{?>
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-color: #7198b9">
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-3 mb-3"></div>

                            <div class="col-md-2 mb-3">
                                <label class="form-label required" for="validationDefault01">Type of Audit</label>
                                <input type="text" class="form-control" id="total_mandays" name="total_mandays"
                                    value="<?php echo $instdel[0]['typeofauditename']; ?>" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label required" for="validationDefault01">Year</label>
                                <input type="text" class="form-control" id="total_mandays" name="total_mandays"
                                    value="<?php echo $instdel[0]['yearname']; ?>" disabled>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label required" for="validationDefault01">Team Head Name</label>
                                <input type="text" class="form-control" id="total_mandays" name="total_mandays"
                                    value="<?php echo $instdel[0]['username']; ?>" disabled>
                            </div>
                            <div class="col-md-3 mb-3"></div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 d-none d-lg-block border-end user-chat-box">
                            <div class="pt-3">
                                <div class="position-relative mb-4">
                                    <input type="text" class="form-control search-chat py-2 ps-5" id="text-srh"
                                        placeholder="Search Slip" />
                                    <i
                                        class="ri ri-search-line position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                                </div>
                            </div>

                            <div class="app-chat">
                                <div class="overflow-auto card mb-0 shadow-none border h-150">
                                    <ul class="chat-users mb-0 mh-n100" data-simplebar>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <B><span id="forwardedby" class="text-end"></span></B>
                            <div class="card" style="border-color: #7198b9">
                                <div class="card-header card_header_color">Auditor Observation</div>

                                <div class="card-body">
                                    <div id="auditslipcard">

                                    </div>

                                    <div id="viewauditslipcard" class="hide_this">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label required"for="validationDefaultUsername">Title/Heading</label>
                                                <select class="select2 form-control custom-select"
                                                    id="view_majorobjectioncode" name="view_majorobjectioncode"
                                                    onchange="getminorobjection()" disabled>
                                                    <option value="">Select Major Objection
                                                    </option>
                                                    @foreach ($get_majorobjection as $ob)
                                                        <option value="{{ $ob->mainobjectionid }}">
                                                            {{ $ob->objectionename }}
                                                            <!-- Display any field you need -->
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 ">
                                                <label class="form-label required" for="validationDefaultUsername">Categorization of paras</label>
                                                <input type="text" id="view_minorobjectioncode"
                                                    name="view_minorobjectioncode" class="form-control" disabled>
                                            </div>

                                            <div class="col-md-4 ">
                                                <label class="form-label required" for="validationDefaultUsername">Amount
                                                    Involved</label>
                                                <input type="text" class="form-control" id="view_amount_involved"
                                                    name="view_amount_involved" placeholder="50,000" disabled>
                                            </div>

                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-md-4 ">
                                                <label class="form-label required"
                                                    for="validationDefaultUsername">Severity</label>
                                                <select class="select2 form-control custom-select" id="view_severityid"
                                                    name="view_severityid" disabled>
                                                    <option value="">Select Severity
                                                    </option>
                                                    <option value="L">Low</option>
                                                    <option value="M">Medium</option>
                                                    <option value="H">High</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 ">
                                                <label class="form-label required" for="validationDefaultUsername">
                                                    Liablility</label> <br>
                                                <div class="form-check form-check-inline">
                                                    <input class="view_form-check-input success" type="radio"
                                                        name="view_liability" id="Y" value="Y" disabled>
                                                    <label class="form-check-label" for="all">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="view_form-check-input success" type="radio"
                                                        name="view_liability" id="N" value="N" checked
                                                        disabled>
                                                    <label class="form-check-label" for="district">No</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 hide_this" id="liabilityname_div">
                                                <label class="form-label required" for="validationDefaultUsername">
                                                    Name</label>
                                                <input type="text" id="view_liabilityname" name="view_liabilityname"
                                                    class="form-control" placeholder="Enter Liability name" disabled>
                                            </div>



                                            <div class="col-md-3">
                                                <label class="form-label required" for="validationDefaultUsername">Slip
                                                    Details</label>
                                                <textarea id="view_slipdetails" name="view_slipdetails" class="form-control" placeholder="Enter remarks" disabled></textarea>
                                            </div>

                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label required" for="validationDefaultUsername">Auditor
                                                    Observation/Remarks</label>
                                                <textarea id="view_auditorremarks" class="form-control" placeholder="Enter remarks" name="view_auditorremarks"></textarea>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label required" for="validationDefaultUsername">Auditor
                                                    Attachments</label>
                                                <div class="container my-1" id="view_file-list-container">
                                                    <!-- File cards will be dynamically injected here -->
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="card-header card_header_color">Auditee Reply</div>

                                            <form id="auditslip" class="mt-2" name="auditslip">
                                                <input type="hidden" name="seriesno" id="seriesno" value='1'>

                                                <input type="hidden" name="fileuploadstatus" id="fileuploadstatus"
                                                    value=''>
                                                <input type="hidden" name="fileuploadid" id="fileuploadid"
                                                    value=''>
                                                <input type="hidden" name="auditslipid" id="auditslipid">

                                                <div id="form_auditeereply" name="form_auditeereply">

                                                    <div class="row">

                                                        <div class="col-md-12" id="remarksedit_div">
                                                            <label class="form-label required"
                                                                for="validationDefaultUsername">Auditee
                                                                Reply</label>
                                                            <textarea id="auditeeremarks" class="form-control hide_this" placeholder="Enter remarks" name="auditeeremarks"></textarea>

                                                        </div>

                                                        <div class="col-md-12 hide_this" id="remarksview_div">
                                                            <label class="form-label required"
                                                            for="validationDefaultUsername">Auditee
                                                            Reply</label>
                                                            <textarea id="view_auditee_reply" class="form-control " placeholder="Enter remarks" name="view_auditee_reply"></textarea>

                                                        </div>
                                                        {{-- </div>
                                                    <div class="row"> --}}
                                                        <div class="col-md-12 hide_this" id="uploadfile_div">
                                                            <label class="form-label required"
                                                                for="validationDefaultUsername"> Upload
                                                                File</label>
                                                            <input type="file" class="form-control"
                                                                id="auditee_upload" name="auditee_upload"
                                                                onclick="importData()" enctype="multipart/form-data">
                                                            <div id="upload_preview" class="preview-container mt-3"
                                                                style="display:none">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 hide_this" id="uploadedfile_div">
                                                            <label class="form-label required"
                                                                for="validationDefaultUsername">
                                                                Attachment</label>
                                                            <div class="container" id="file-list-container">
                                                                <!-- File cards will be dynamically injected here -->
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>



                                                <div class="row mt-4" id="showbtn">
                                                    <div class="col-md-6" style="margin-left: 39% !important;">
                                                        <div class="d-flex align-items-center gap-6">
                                                            <input type="hidden" id="action" name="action"
                                                                value="insert">
                                                            <button class="btn button_save" id="buttonaction"
                                                                name="buttonaction">Save
                                                                / Draft</button>
                                                            <button class="btn button_finalise"
                                                                id="approvebtn">Finalise</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
     </div>   

     <?php

}
else
{?>

    <div class="card " style="border-color: #7198b9">
        <div class="card-header card_header_color">Slip Details</div>
            <div class="card-body"><br>
                <center>No Data Available</center>

            </div>
        </div>
    </div>

<?php

}?>

        <script src="../assets/js/vendor.min.js"></script>
        <script src="../assets/js/apps/chat.js"></script>
        <script src="../assets/libs/jquery-validation/dist/jquery.validate.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>


        <script>
            /*************************************************  Audit Tab Functions *********************************************/


            /*************************************************  Ckeditor  *********************************************/

            let auditee_reply;

            CKEDITOR.ClassicEditor.create(document.getElementById("view_auditee_reply"), {
                    toolbar: {
                        items: [
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            'fontSize', 'fontFamily', '|',
                            'alignment', '|',
                            'uploadImage', 'insertTable',
                            '|',
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                    fontFamily: {
                        options: [
                            'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                            'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif',
                            'Times New Roman, Times, serif', 'Trebuchet MS, Helvetica, sans-serif',
                            'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    fontSize: {
                        options: [10, 12, 14, 'default', 18, 20, 22],
                        supportAllValues: true
                    },
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    removePlugins: [
                        'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                        'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                        'WProofreader',
                        'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                        'PasteFromOfficeEnhanced', 'CaseChange'
                    ]
                })
                .then(editor => {
                    auditee_reply = editor;
                    auditee_reply.enableReadOnlyMode('initial');

                    // Disable editing (make read-only)
                    // view_editor.enableReadOnlyMode();
                })
                .catch(error => {
                    console.error(error);
                });


            let editor;

            CKEDITOR.ClassicEditor.create(document.getElementById("auditeeremarks"), {
                    toolbar: {
                        items: [
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            'fontSize', 'fontFamily', '|',
                            'alignment', '|',
                            'uploadImage', 'insertTable',
                            '|',

                        ],
                        shouldNotGroupWhenFull: true
                    },
                    placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                    fontFamily: {
                        options: [
                            'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                            'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif', 'Times New Roman, Times, serif',
                            'Trebuchet MS, Helvetica, sans-serif', 'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    fontSize: {
                        options: [10, 12, 14, 'default', 18, 20, 22],
                        supportAllValues: true
                    },
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    removePlugins: [
                        'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                        'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                        'WProofreader',
                        'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                        'PasteFromOfficeEnhanced', 'CaseChange'
                    ]
                })
                .then(e => {
                    editor = e;
                })
                .catch(error => {
                    console.error(error);
                });





            let view_editor;

            CKEDITOR.ClassicEditor.create(document.getElementById("view_auditorremarks"), {
                    toolbar: {
                        items: [
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'underline', '|',
                            'numberedList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            'fontSize', 'fontFamily', '|',
                            'alignment', '|',
                            'uploadImage', 'insertTable',
                            '|',
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    placeholder: 'Welcome to CAMS... Write Your Audit Objection here',
                    fontFamily: {
                        options: [
                            'default', 'Marutham', 'Arial, Helvetica, sans-serif', 'Courier New, Courier, monospace',
                            'Georgia, serif', 'Lucida Sans Unicode, Lucida Grande, sans-serif',
                            'Tahoma, Geneva, sans-serif',
                            'Times New Roman, Times, serif', 'Trebuchet MS, Helvetica, sans-serif',
                            'Verdana, Geneva, sans-serif'
                        ],
                        supportAllValues: true
                    },
                    fontSize: {
                        options: [10, 12, 14, 'default', 18, 20, 22],
                        supportAllValues: true
                    },
                    htmlSupport: {
                        allow: [{
                            name: /.*/,
                            attributes: true,
                            classes: true,
                            styles: true
                        }]
                    },
                    link: {
                        decorators: {
                            addTargetToExternalLinks: true,
                            defaultProtocol: 'https://',
                            toggleDownloadable: {
                                mode: 'manual',
                                label: 'Downloadable',
                                attributes: {
                                    download: 'file'
                                }
                            }
                        }
                    },
                    removePlugins: [
                        'AIAssistant', 'CKBox', 'CKFinder', 'EasyImage', 'Base64UploadAdapter', 'MultiLevelList',
                        'RealTimeCollaborativeComments', 'RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory',
                        'PresenceList', 'Comments', 'TrackChanges', 'TrackChangesData', 'RevisionHistory', 'Pagination',
                        'WProofreader',
                        'MathType', 'SlashCommand', 'Template', 'DocumentOutline', 'FormatPainter', 'TableOfContents',
                        'PasteFromOfficeEnhanced', 'CaseChange'
                    ]
                })
                .then(editor => {
                    view_editor = editor;
                    view_editor.enableReadOnlyMode('initial');

                    // Disable editing (make read-only)
                    // view_editor.enableReadOnlyMode();
                })
                .catch(error => {
                    console.error(error);
                });


            /*************************************************  Ckeditor  *********************************************/


            /***************************************************** Upload File - Preview *********************************/

            function importData() {
                // Dynamically create a file input element
                let input = document.createElement('input');
                input.type = 'file';

                // Handle file selection
                input.onchange = () => {
                    let files = Array.from(input.files);

                    // Synchronize the files with the original input
                    document.getElementById('auditee_upload').files = input.files;

                    // Pass the selected file to the previewAttachment function
                    previewAttachment(input, 'upload_preview');
                };

                // Trigger the file dialog
                input.click();
            }

            function previewAttachment(input, previewDivId) {
                // Ensure a file is selected
                if (!input.files || input.files.length === 0) return;

                const file = input.files[0];
                const previewDiv = document.getElementById(previewDivId);

                // Clear the preview area
                previewDiv.innerHTML = "";

                if (file) {
                    const fileType = file.type;
                    $('#upload_preview').show();

                    // Check if the uploaded file is an image
                    if (fileType.startsWith("image/")) {
                        const img = document.createElement("img");
                        img.src = URL.createObjectURL(file);
                        img.style.maxWidth = "100%";
                        img.style.maxHeight = "400px";

                        previewDiv.appendChild(img);
                    }
                    // Check if the uploaded file is a PDF
                    else if (fileType === "application/pdf") {
                        const iframe = document.createElement("iframe");
                        iframe.src = URL.createObjectURL(file);
                        iframe.style.width = "100%";
                        iframe.style.height = "400px";
                        iframe.setAttribute("frameborder", "0");
                        previewDiv.appendChild(iframe);
                    }
                    // Handle unsupported file types
                    else {
                        const message = document.createElement("p");
                        message.textContent = "Unsupported file type. Please upload an image or a PDF.";
                        previewDiv.appendChild(message);
                    }
                }
            }

            /***************************************************** Upload File - Preview *********************************/



            ////////////////////////////////////// Search Audit Slip Number //////////////////////////////////////

            $(".search-chat").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".chat-users li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            ////////////////////////////////////// Search Audit Slip Number //////////////////////////////////////





            getauditslip('', 'fetch', '')

            /*********************************************** Jqury Form Validation *******************************************/


            $("#auditslip").validate({
                // rules: {
                //     majorobjectioncode: {
                //         required: true,
                //     },
                //     minorobjectioncode: {
                //         required: true
                //     },


                // },
                // messages: {

                //     liability: {
                //         required: "Select liablility",
                //     },
                //     liabilityname: {
                //         required: "Select liability name",
                //     },
                // }
                rules: {
                    auditeeremarks: {
                        required: function() {
                            // Get content from CKEditor
                            let content = editor.getData().trim();
                            return content === '' || content === '<p>&nbsp;</p>';
                        }
                    },
                    auditee_upload: {
                        required: true,
                    }

                },
                messages: {
                    auditeeremarks: {
                        required: "Please enter your remarks. This field cannot be empty."
                    }
                },
                auditee_upload: {
                    required: true,
                },
            });

            /*********************************************** Jqury Form Validation *******************************************/


            /*********************************************** Insert,update,finalise,reset *******************************************/

            // Event listener for the button to add a new slip number
            $("#approvebtn").on("click", function() {

                event.preventDefault();
                // Trigger the form validation
                if ($("#auditslip").valid()) {
                    document.getElementById("process_button").onclick = function() {
                        createslip('Y')
                    };
                    // Show confirmation alert
                    passing_alert_value('Confirmation', 'Are Sure to forward?', 'confirmation_alert', 'alert_header',
                        'alert_body', 'forward_alert');
                } else {}
            });

            $("#buttonaction").on("click", function(event) {
                // Prevent form submission (this stops the page from refreshing)
                event.preventDefault();

                //Trigger the form validation
                if ($("#auditslip").valid()) {
                    createslip('N')
                } else {

                }
            });

            function createslip(finalise) {
                var formData = new FormData($('#auditslip')[0]); // Serialize form data, including files

                formData.append('finaliseflag', finalise);
                formData.append('teamheadid', <?php echo $teamheadid; ?>);
                formData.append('fileuploadstatus', $('#fileuploadstatus').val());
                formData.append('auditeeremarks_append', editor.getData());



                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        // 'Content-Type': 'application/x-www-form-urlencoded',
                    }
                });


                $.ajax({
                    url: '/auditeereply', // URL where the form data will be posted
                    type: 'POST',
                    data: formData,
                    processData: false, // Disable automatic data processing
                    contentType: false, // Let jQuery handle the content type for FormData
                    success: function(response) {
                        if (response.success) {
                            reset_form(); // Reset the form after successful submission
                            passing_alert_value('Confirmation', response.message,
                                'confirmation_alert', 'alert_header', 'alert_body',
                                'confirmation_alert');

                            // table.ajax.reload(); // Reload the table with the new data
                            getauditslip('', 'fetch', response.data)

                        } else if (response.error) {
                            // Handle errors if needed
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {

                        var response = JSON.parse(xhr.responseText);

                        var errorMessage = response.error ||
                            'An unknown error occurred';

                        // // Extracting error details
                        // var errorMessage = 'An error occurred.';

                        // Optionally, you can check for the type of error
                        // if (xhr.status === 400) {
                        //     // Example of handling 400 Bad Request error
                        //     errorMessage =  xhr.responseText;
                        // } else if (xhr.status === 500) {
                        //     // Example of handling 500 Internal Server Error
                        //     errorMessage = 'Server error: ' + xhr.responseText;
                        // } else {
                        //     // You can include the status or other relevant details
                        //     errorMessage = 'Error ' + xhr.status + ': ' + error;
                        // }

                        // Displaying the error message
                        passing_alert_value('Alert', errorMessage, 'confirmation_alert',
                            'alert_header', 'alert_body', 'confirmation_alert');


                        // Optionally, log the error to console for debugging
                        console.error('Error details:', xhr, status, error);
                    }
                });

            }


            function reset_form() {
                $("#auditslip").validate().resetForm(); // Reset the validation errors
                $("#auditslip")[0].reset(); // Optionally reset the form fields as well
                change_button_as_insert('auditslip', 'action', 'buttonaction', 'display_error', '', '');
                updateSelectColorByValue(document.querySelectorAll(".form-select"));
            }


            /*********************************************** Insert,update,finalise,reset *******************************************/




            /*********************************************** Fetch Data *******************************************/

            function getauditslip(slipid, action, fixid) {


                $.ajax({
                    url: '/getauditslip', // Your API route to get user details
                    method: 'POST',
                    data: {
                        auditslipid: slipid,
                        auditscheduleid: '<?php echo $auditscheduleid; ?>'
                    }, // Pass deptuserid in the data object
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#upload_preview').hide();
                            if (response.data && response.data.auditDetails.length > 0) {
                                // let firstItem = response.data.auditDetails[0];
                                // $('#auditslipid').val(firstItem.encrypted_auditslipid);


                                if (fixid == '') {
                                    seriesnumber = Number($('#seriesno').val());
                                    firstItem = response.data.auditDetails[0];
                                    firstItemremarks = '';


                                    response.data.auditorRemarks.forEach(function(auditeeremarks) {

                                        if (firstItem.mainslipnumber == auditeeremarks.mainslipnumber) {
                                            firstItemremarks = auditeeremarks;
                                        }

                                    });
                                    fixarrow = seriesnumber;
                                }


                                if (action == 'fetch') {
                                    $('#seriesno').val(1);
                                    const chatUsersList = document.querySelector(".chat-users");
                                    // Clear any existing content inside the chatUsersList (if needed)
                                    chatUsersList.innerHTML = '';
                                    seriesnumber = Number($('#seriesno').val());



                                    response.data.auditDetails.forEach(function(item) {
                                        addSlipNumber(item.mainslipnumber, item.encrypted_auditslipid);
                                        if (fixid) {
                                            if (fixid == item.mainslipnumber) {
                                                fixarrow = $('#seriesno').val() - 1;
                                                firstItem = item;
                                            }
                                        }
                                    });
                                    $('#arrow_' + fixarrow).show();
                                } else {
                                    // 'trans_auditslip.mainslipnumber',
                                }

                                //show_view_card(firstItem);

                                if (fixid != '') {

                                    if (response.data.auditorRemarks.length > 0) {
                                        response.data.auditorRemarks.forEach(function(auditeeremarks) {
                                            if (fixid) {
                                                if (fixid == auditeeremarks.mainslipnumber) {
                                                    firstItemremarks = auditeeremarks;
                                                }
                                            }
                                        });




                                        // let auditeeremarks = response.data.auditDetails[0];
                                        // if (auditeeremarks)
                                        // {
                                        //     const fileDetailsString = response.data.auditorRemarks[0]
                                        //         .filedetails_1; // Assuming this is the response field
                                        //     const fileDetailsArray = fileDetailsString.split(
                                        //         ','); // Split by comma for each file

                                        //     // alert(firstItem.filedetails_1);
                                        //     if (firstItem.filedetails_1)
                                        //     {
                                        //         $('#file-list-container').show()
                                        //     }


                                        //     // $('#file-list-container').show()

                                        //     // Prepare files array for rendering
                                        //     const files = fileDetailsArray.map((fileDetail, index) => {
                                        //         const [name, path, size, fileuploadid] = fileDetail.split(
                                        //             '-'); // Split by hyphen
                                        //         return {
                                        //             id: index +
                                        //                 1, // Example ID (you can use an actual ID if available)
                                        //             name: name,
                                        //             path: path,
                                        //             size: size,
                                        //             fileuploadid: fileuploadid,
                                        //         };
                                        //     });
                                        //     if (auditeeremarks.processcode == 'F') {
                                        //         $('#showbtn').show();
                                        //         $('#fileuploadstatus').val('N');
                                        //         change_button_as_update('auditslip', 'action', 'buttonaction',
                                        //             'display_error', '', '');
                                        //         $('#remarksview_div').hide();
                                        //         $('#remarksedit_div').show()
                                        //         $('#uploadedfile_div').show()
                                        //         $('#uploadfile_div').hide()

                                        //         editor.setData(response.data.auditorRemarks[0].auditeeremarks);

                                        //         renderFileList(files, 'edit');
                                        //     } else if (auditeeremarks.processcode == 'R') {
                                        //         $('#showbtn').hide();
                                        //         $('#uploadedfile_div').show()
                                        //         $('#remarksedit_div').hide();
                                        //         $('#remarksview_div').show();
                                        //         $('#file-list-container').show()
                                        //         $('#uploadfile_div').hide()
                                        //         renderFileList(files, 'view');
                                        //         auditee_reply.setData(response.data.auditorRemarks[0].auditeeremarks);
                                        //     }


                                        // }


                                    }


                                }



                                if (firstItem) {
                                    $('#auditslipid').val(firstItem.encrypted_auditslipid);
                                    // alert($('#auditslipid').val())
                                    show_view_card(firstItem);
                                }


                                if (firstItemremarks) {

                                    const fileDetailsString = firstItemremarks.filedetails_1;
                                    const fileDetailsArray = fileDetailsString.split(',');
                                    if (firstItem.filedetails_1) {
                                        $('#file-list-container').show()
                                    }
                                    const files = fileDetailsArray.map((fileDetail, index) => {
                                        const [name, path, size, fileuploadid] = fileDetail.split(
                                            '-'); // Split by hyphen
                                        return {
                                            id: index +
                                                1, // Example ID (you can use an actual ID if available)
                                            name: name,
                                            path: path,
                                            size: size,
                                            fileuploadid: fileuploadid,
                                        };
                                    });

                                    if (firstItem.processcode == 'F') {
                                        change_button_as_update('auditslip', 'action', 'buttonaction',
                                            'display_error', '', '');
                                        $('#showbtn').show();
                                        $('#fileuploadstatus').val('N');
                                        $('#remarksview_div').hide();
                                        $('#remarksedit_div').show()
                                        $('#uploadedfile_div').show()
                                        $('#uploadfile_div').hide()
                                        editor.setData(firstItemremarks.auditeeremarks);
                                        renderFileList(files, 'edit');
                                    } else if ((firstItem.processcode == 'R') || (firstItem.processcode == 'X') || (
                                            firstItem.processcode == 'A')) {
                                        $('#showbtn').hide();
                                        $('#uploadedfile_div').show()
                                        $('#remarksedit_div').hide();
                                        $('#remarksview_div').show();
                                        $('#file-list-container').show()
                                        $('#uploadfile_div').hide()
                                        renderFileList(files, 'view');
                                        auditee_reply.setData(firstItemremarks.auditeeremarks);
                                    }

                                } else {
                                    // alert('hi');
                                    $('#remarksview_div').hide();
                                    $('#showbtn').show();
                                    $('#action').val('insert');
                                    $('#buttonaction').html("Save Draft");
                                    $('#fileuploadid').val('');


                                    document.getElementById('buttonaction').style.backgroundColor = "#b71362";
                                    document.getElementById('buttonaction').style.color = "#FFFFFF";

                                    $('#uploadedfile_div').hide()
                                    $('#fileuploadstatus').val('Y');
                                    $('#remarksedit_div').show()
                                    $('#uploadfile_div').show()
                                }



                            }
                        } else {
                            alert('User not found');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });

            }


            function show_view_card(firstItem) {
                $('#viewauditslipcard').show();
                $('#view_majorobjectioncode').val(firstItem.mainobjectionid);
                $('#view_amount_involved').val(firstItem.amtinvolved);
                $('#view_slipdetails').val(firstItem.slipdetails);
                $('#view_auditorremarks').val(firstItem.auditorremarks);
                $('#view_severityid').val(firstItem.severity);
                $('#view_minorobjectioncode').val(firstItem.subobjectionename);

                if (firstItem.liability == 'Y') {
                    liability = 'Yes';
                    $('#liabilityname_div').show();
                    $('#view_liabilityname').val(firstItem.liabilityname);
                } else {
                    liability = 'No';
                    $('#liabilityname_div').hide();
                    $('#view_liabilityname').val('');

                }
                $('input[name="view_liability"][value="' + firstItem.liability + '"]').prop(
                    'checked', true);
                const fileDetailsString = firstItem
                    .filedetails_1; // Assuming this is the response field
                const fileDetailsArray = fileDetailsString.split(
                    ','); // Split by comma for each file

                // alert(firstItem.filedetails_1);
                if (firstItem.filedetails_1) {
                    $('#file-list-container').show()
                }


                const files = fileDetailsArray.map((fileDetail, index) => {
                    const [name, path, size, fileuploadid] = fileDetail.split(
                        '-'); // Split by hyphen
                    return {
                        id: index +
                            1, // Example ID (you can use an actual ID if available)
                        name: name,
                        path: path,
                        size: size,
                        fileuploadid: fileuploadid,
                    };
                });
                view_files(files);
                view_editor.setData(firstItem.auditorremarks);
                auditeeremarks
                // view_editor.isReadOnly = true;
            }

            /*********************************************** Fetch Data *******************************************/





            /*********************************************** Automatic Slip Add *******************************************/


            function addSlipNumber(slipNumber, id) {
                // Check if slipNumber is not provided
                if (!slipNumber) {
                    var stringValue = $('#autoslipnumber').val(); // Get value of the slip number input
                    var intValue = Number(stringValue); // Convert string to number using Number()
                    if (isNaN(intValue)) intValue = 0;
                    slipNumber = intValue;
                }

                // Ensure id is not null or undefined (set to empty string by default)
                if (!id) id = '';

                // Get the 'ul' element where the slip numbers are listed
                const chatUsersList = document.querySelector(".chat-users");

                // Create a new 'li' element for the new slip number
                const newListItem = document.createElement("li");

                seriesno = $('#seriesno').val();

                // Add the HTML content for the new 'li'
                newListItem.innerHTML = `
            <div class="hstack p-2 bg-hover-light-black position-relative border-bottom " id="${seriesno}" onclick="handleSlipClick('${seriesno}')">
                <input type="hidden" id="slipid_${seriesno}" name="slipid" value="${id}">
                <input type="hidden" id="slipnumber_${seriesno}" name="slipnumber_${seriesno}" value='${slipNumber}'>

                <a style="color:black;" href="javascript:void(0)" class="stretched-link"></a>
                <div class="ms-2">
                    <a style="color:black;" href="javascript:void(0)">
                        <i class="text-primary ri ri-clipboard-text fs-5"></i>
                    </a>
                </div>
                <div class="ms-auto">
                    <h6 class="mb-0">${slipNumber}</h6>
                </div>
                <div class="ms-auto">
                    <a style="color:black;" href="javascript:void(0)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="currentColor"
                            class="icon icon-tabler icons-tabler-filled icon-tabler-arrow-big-right-lines slip-arrow" style="display:none" id="arrow_${seriesno}">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.585l-1.999 .001a1 1 0 0 0 -1 1v6l.007 .117a1 1 0 0 0 .993 .883l1.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" />
                            <path d="M3 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                            <path d="M6 8a1 1 0 0 1 .993 .883l.007 .117v6a1 1 0 0 1 -1.993 .117l-.007 -.117v-6a1 1 0 0 1 1 -1z" />
                        </svg>
                    </a>
                </div>
            </div>`;

                // Append the new 'li' to the list
                chatUsersList.appendChild(newListItem);

                // Increment the slip number and series number
                slipNumber = slipNumber + 1;
                seriesno = Number($('#seriesno').val()) + 1;

                // Update the value of the autoslipnumber input field
                $('#autoslipnumber').val(slipNumber);
                $('#seriesno').val(seriesno);

                // Flag to check if the click handler has been triggered before
                let clickHandled = false;

                // // Attach the click event listener using event delegation
                // $(".chat-users").on("click", ".getfullslipdetails", function() {
                //     if (clickHandled) return; // If the click was already handled, do nothing

                //     const clickedId = $(this).attr('id');  // Get the ID of the clicked element

                //     currentslipnumber = $('#slipnumber_' + clickedId).val();
                //     currentslipid = $('#slipid_' + clickedId).val();

                //     $('#currentslipnumber').val(currentslipnumber);
                //     $('#auditslipid').val(currentslipid);

                //     $(".slip-arrow").hide();
                //     $('#arrow_' + clickedId).show();

                //     $("#auditslip").validate().resetForm(); // Reset the validation errors
                //     $("#auditslip")[0].reset(); // Optionally reset the form fields as well

                //     if (currentslipid) {
                //         getauditslip(currentslipid);
                //     }

                //     // Set the flag to prevent further clicks
                //     //clickHandled = true;
                // });
            }

            function handleSlipClick(seriesno) {


                // alert(seriesno);
                $('#upload_file').show();
                $('#fileuploadstatus').val('Y');
                $('#fileuploadid').val('');
                editor.setData('');
                $('#auditee_upload').val('');
                const fileListContainer = $('#file-list-container');
                fileListContainer.empty(); // Clear previous file cards
                $('#file-list-container').hide();

                //$('#upload_file').show();
                // $('#file-list-container').hide();

                const clickedId = seriesno; // Get the ID of the clicked element
                currentslipnumber = $('#slipnumber_' + clickedId).val();
                currentslipid = $('#slipid_' + clickedId).val();
                $('#upload_preview').hide();
                if (currentslipid) {
                    getauditslip(currentslipid, 'edit', '');
                } else {
                    $('#forwardedby').html('Initiated By Self')
                    reset_form();
                    $('#auditslipcard').show();
                    $('#viewauditslipcard').hide();
                }



                $('#currentslipnumber').val(currentslipnumber);
                $('#auditslipid').val(currentslipid);

                $(".slip-arrow").hide();
                $('#arrow_' + clickedId).show();



            }

            // When the 'Add Slip Number' button is clicked (directly, no modal)
            $("#add-button").click(function() {
                addSlipNumber(); // Add a new slip number when the button is clicked
            });

            /*********************************************** Automatic Slip Add *******************************************/



            /**************************************** Fit the upload files, delete upload file in s **********************/

            function renderFileList(files, action) {
                $('#file-list-container').show(); // Show the container
                const fileListContainer = $('#file-list-container');
                fileListContainer.empty(); // Clear previous file cards


                files.forEach(file => {
                    // alert(file.fileuploadid)

                    $('#fileuploadid').val(file.fileuploadid);

                    // Start building the file card
                    let fileCard = `
            <div class=" overflow-hidden mb-3" id="file-card-${file.id}">
                <input type="hidden" id="fileuploadid_${file.id}" name="fileuploadid_${file.id}" value="${file.fileuploadid}">
                <div class="d-flex flex-row">
                    <div class="p-2 align-items-center">
                        <h3 class="text-danger box mb-0 round-56 p-2">
                            <i class="ti ti-file-text"></i>
                        </h3>
                    </div>
                    <div class="p-3">
                        <h3 class="text-dark mb-0 fs-4">
                            <a style="color:black;" href="/storage/${file.path}" target="_blank">${file.name}</a>
                        </h3>
                    </div>`;

                    // Add action buttons if in 'edit' mode
                    if (action === 'edit') {
                        fileCard += `
                        <div class="ms-auto">
                            <button class="text-danger box mb-0" onclick="deleteFile(${file.id}, event)">
                                <i class="ti ti-trash"></i> Delete
                            </button>
                        </div>`;
                    }

                    // Close the file card container
                    fileCard += `
                </div>
            </div>
        `;

                    // Append the file card to the container
                    fileListContainer.append(fileCard);
                });
            }



            function view_files(files) {

                const fileListContainer = $('#view_file-list-container');
                fileListContainer.empty(); // Clear previous file cards

                files.forEach(file => {

                    const fileCard = `
                <div class=" overflow-hidden mb-3" id="viewfile-card-${file.id}">
                    <div class="d-flex flex-row">
                        <div class="p-2 align-items-center">
                            <h3 class="text-danger box mb-0 round-56 p-2">
                                <i class="ti ti-file-text"></i>
                            </h3>
                        </div>
                        <div class="p-3">
                            <h3 class="text-dark mb-0 fs-4">
                                <!-- Add an anchor tag to open the file in a new tab -->
                                <a style="color:black;" href="/storage/${file.path}" target="_blank">${file.name}</a>                        </h3>
                        </div>


                    </div>
                </div>
            `;

                    // <div class="p-3 align-items-center ms-auto">
                    //     <a href="/files/download/${file.id}" class="text-primary box mb-0">
                    //         <i class="ti ti-download"></i> Download
                    //     </a>
                    // </div>
                    fileListContainer.append(fileCard); // Add the file card to the container
                });
            }

            // Function to delete a file
            function deleteFile(fileId, event) {
                event.preventDefault(); // Prevents page refresh

                // Set up the confirmation process
                document.getElementById("process_button").onclick = function() {
                    deletefilefromview(fileId);
                };

                // Show confirmation alert
                passing_alert_value('Confirmation', "Are you sure you want to delete this file?", 'confirmation_alert',
                    'alert_header', 'alert_body', 'forward_alert');
            }

            function deletefilefromview(fileId) {
                $('#file-card-' + fileId).hide();

                // // Optionally, remove the file ID from activefileid (if necessary)
                // var activeFileIds = $('#active_fileid').val().split(',');
                // activeFileIds = activeFileIds.filter(function(id) {
                //     return id != fileId;
                // });
                // $('#active_fileid').val(activeFileIds.join(','));


                // // Get the current deactivefileid value and ensure it is an array
                // var deactiveFileIds = $('#deactive_fileid').val().split(',').filter(function(id) {
                //     return id !== ''; // Remove empty values (in case there's a leading comma)
                // });

                // // Add the file ID to deactivefileid if not already present
                // if (!deactiveFileIds.includes(fileId.toString())) {
                //     deactiveFileIds.push(fileId);
                // }

                // // Join the array with commas and update the deactive_fileid hidden input field
                // $('#deactive_fileid').val(deactiveFileIds.join(','));
                $('#uploadfile_div').show();
                $('#fileuploadstatus').val('Y');
                $('#uploadedfile_div').hide();


            }

            /**************************************** Fit the upload files, delete upload file in edit **********************/


            /*************************************************  Audit Tab Functions *********************************************/
        </script>
    @endsection
