@extends('index2')
@section('content')
<link rel="stylesheet" href="../assets/libs/dragula/dist/dragula.min.css">
<style>

.equal-height {
        display: flex;
        flex-wrap: wrap;
    }

    .equal-height .card {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .dd-list .dd-item
    {
        padding:1px;
    }
#pdf-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3); /* Lighten the background color, or set to 'transparent' */
    z-index: 1000;
}

#pdf-modal > div {
    position: relative;
    width: 80%;
    height: 80%;
    margin: 50px auto;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}

#close-modal {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 24px;
    cursor: pointer;
    color: black;
}

#pdf-preview {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

#pdf-preview iframe {
    width: 100%;
    height: 100%;
    border: none;
}


</style>
<div class="card" style="border-color: #7198b9">
    <div class="card-header card_header_color" style="padding:10px;">AUDIT SLIP</div>
    <div class="card-body calender-sidebar app-calendar">
        <div class="row equal-height">
            <!-- PART A -->
            <div class="col-md-6 col-xxl-4">
                <div class="card" style="border-color: #7198b9">
                    <div class="card-body draggable-container" >
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <h4 class="card-title mb-3">PART A</h4>
                        <!--<button class="btn bg-primary-subtle" type="button" id="invest1">
                            PART - A
                        </button>-->
                    </div>

                        <div id="part-a">
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-calendar text-warning me-2" style="font-size:15px;"></i>
                                        <span class="text-muted">Intimation Letter</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-calendar text-warning me-2" style="font-size:15px;"></i>
                                        <span class="text-muted">Entry Meeting</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-file display-7 text-info me-2"></i>
                                        <span class="text-muted">Code Of Ethics</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-file display-7 text-info me-2"></i>
                                        <span class="text-muted">Minute of Meeting</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-file display-7 text-info me-2"></i>
                                        <span class="text-muted">Work Allocation</span>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <i class="fa fa-file text-info me-2"></i>
                                        <span class="text-muted">Exit Meeting</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PART B -->
            <div class="col-md-6 col-xxl-4">
                <div class="card" style="border-color: #7198b9;">
                    <div class="card-body draggable-container" id="part-b">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <h4 class="card-title mb-0">PART B</h4>
                        </div>
                        <br>
                        <div class="myadmin-dd dd" id="nestable">
                            <ol class="dd-list">
                            <li class="dd-item" data-id="2"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
                                <div class="dd-handle">Serious Irregularities</div>
                                <ol class="dd-list">
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">Money Value</div>
                                </li>
                                <li class="dd-item" data-id="4">
                                    <div class="dd-handle">Court Cases</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Property Based</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Encroachment</div>
                                </li>
                                </ol>
                            </li>
                            <li class="dd-item" data-id="2"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
                                <div class="dd-handle">Non Serious Irregularities</div>
                                <ol class="dd-list">
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">Non Money Value Paras</div>
                                </li>
                                <li class="dd-item" data-id="4">
                                    <div class="dd-handle">Budget Sanction</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Procedure not followed</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Registers / Records not maintained</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Expenditure Plan</div>
                                </li>
                                </ol>
                            </li>
                            </ol>
                        </div>
                        <!--@foreach ($auditSlips as $slipkey => $slipval)
                            <div class="row mt-3 draggable-item">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" class="d-flex align-items-center justify-content-center rounded-4 border py-3 text-decoration-none">
                                        <span class="text-muted">PARA - {{ $slipkey+1 }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach-->
                    </div>
                </div>
            </div>


            <!-- PART C -->
            <div class="col-md-6 col-xxl-4" style="">
                <div class="card" style="border-color: #7198b9;">
                    <div class="card-body draggable-container" id="part-b">
                        <div class="d-flex justify-content-center align-items-center flex-column">
                            <h4 class="card-title mb-0">PART C</h4>
                        </div>
                        <br>
                        <div class="myadmin-dd dd" id="nestable-menu">
                            <ol class="dd-list">
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">Pending Para's count</div>
                            </li>
                            <li class="dd-item" data-id="2">
                                <div class="dd-handle">Current Para's count</div>
                            </li>
                            
                            <li class="dd-item" data-id="2"><button data-action="collapse" type="button">Collapse</button><button data-action="expand" type="button" style="display: none;">Expand</button>
                                <div class="dd-handle">Annexures </div>
                                <ol class="dd-list">
                                <li class="dd-item" data-id="3">
                                    <div class="dd-handle">Receipts & charges</div>
                                </li>
                                <li class="dd-item" data-id="4">
                                    <div class="dd-handle">Income & Expenditure</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Account Statement</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Balance Sheet</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Abstract of Accounts</div>
                                </li>
                                <li class="dd-item" data-id="4">
                                    <div class="dd-handle">DCB Statements</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Statement of Investments</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Yearly Account Statements</div>
                                </li>
                                <li class="dd-item" data-id="9">
                                    <div class="dd-handle">Other Attachments related to the Para's</div>
                                </li>
                                </ol>
                            </li>
                            </ol>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div align="center" class="btn-container" id="generate-pdf" style="font-size: 15px;">
            <a class="btn btn-primary"> <i class="fas fa-file-pdf" ></i>&nbsp;&nbsp;Generate Draft Audit</a>
        </div>
        <br>
    </div>
</div>

<!-- Modal for PDF Preview -->
<div id="pdf-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1000;">
    <div style="position: relative; width: 80%; height: 80%; margin: 50px auto; background: white; border-radius: 8px; overflow: hidden;">
        <span id="close-modal" style="position: absolute; top: 10px; right: 20px; font-size: 24px; cursor: pointer; color: black;">&times;</span>
        
        <!-- PDF Preview Heading -->
        <div style="text-align: center; padding: 10px; background: #f1f1f1;">
            <h3>PDF Preview</h3>
        </div>

        <!-- PDF Preview Container -->
        <div id="pdf-preview" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
            <!-- The iframe will be inserted dynamically here -->
        </div>
    </div>
</div>


<script src="../assets/libs/dragula/dist/dragula.min.js"></script>
   <!-- solar icons -->
   <script src="../assets/libs/nestable/jquery.nestable.js"></script>
    <script src="../assets/js/plugins/nestable-init.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Define containers
        var containers = [
            document.getElementById('part-a'),
            //document.getElementById('part-b')
        ];
       $('#nestable-menu').nestable();

        // Initialize Dragula
        dragula(containers).on('drop', function (el, target, source, sibling) {
            console.log('Element dropped:', el);
            console.log('Source container:', source.id);
            console.log('Target container:', target.id);
        });
    });

    $(document).ready(function () {
        // CSRF Token setup for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Generate and Preview PDF
        $('#generate-pdf a').on('click', function () {
            $.ajax({
                url: '/generate-pdf',
                method: 'GET',
                success: function (response) {
                    if (response.status === 'success') {
                        // Decode the Base64 string into a Blob
                        const pdfBlob = new Blob([Uint8Array.from(atob(response.pdf), c => c.charCodeAt(0))], { type: 'application/pdf' });

                        // Create a URL for the Blob
                        const pdfURL = URL.createObjectURL(pdfBlob);

                        // Show the modal
                        $('#pdf-modal').fadeIn();

                        // Embed the PDF in the preview container
                        const iframe = `<iframe src="${pdfURL}#toolbar=0&navpanes=0" style="width: 80%; height: 90%; border: none;"></iframe>`;
                    $('#pdf-preview').html(iframe);
                    } else {
                        alert('Failed to generate PDF.');
                    }
                },
                error: function (xhr) {
                    alert('An error occurred while generating the PDF.');
                    console.error(xhr.responseText);
                }
            });
        });

        // Close the Modal
        $('#close-modal').on('click', function () {
            $('#pdf-modal').fadeOut();
        });
    });
</script>
@endsection
