<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    // Define variables at the class level
    private $tamilfontfile = 'NotoSansTamil-Regular.ttf';
    private $tamilfontname = 'noto';

    public static function codeofethics()
    {
        $mpdf = new Mpdf();

        // Path to the HTML file
        $htmlFilePath = resource_path('views/pdf/codeofethics.html'); // Adjust path as needed

        // Set up the page (optional)
        $mpdf->AddPage();

        // Set the border properties (e.g., color, width)
        $mpdf->SetLineWidth(1); // Set the border width
        $mpdf->SetDrawColor(0, 0, 0); // Set the border color (Black)

        // Draw a border around the page (Rect(x, y, width, height))
        // You can adjust the dimensions as needed to control where the border appears.
        $mpdf->Rect(10, 10, 190, 277); // (X, Y, Width, Height)

        $htmlContent = file_get_contents($htmlFilePath);

        $dynamicData = [
            'name' => 'Test',
            'designation' => 'Test',
            'currentdate' =>date('d-m-Y')
        ];

        // Replace placeholders with dynamic values
        foreach ($dynamicData as $key => $value) {
            // Replace {{key}} with actual values
            $htmlContent = str_replace('{{' . $key . '}}', $value, $htmlContent);
        }

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($htmlContent);

        $filename = 'codeofethics.pdf'; // Change this to your desired file name

        // Output the PDF to browser with the specified filename for download
        return response($mpdf->Output($filename, 'D'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function entrymeeting(Request $request)
    {
        // Load content from JSON file
        $jsonFilePath = public_path('json/pdfcontent.json');        
        $jsonContent = file_get_contents($jsonFilePath);
        $data = json_decode($jsonContent, true);

        $language = $request->lang; //en or ta

        $title = $data['entrypdf_'.$language.'']['title'];

        $tablecontents =$data['entrypdf_'.$language.''];

        unset($tablecontents['title']);

        $tabledata = '';
        $sno = 1;
        $x=0;
        $ValuesEcho =array('Test','Test','Test','Test','Test','Test','','','','','Test','','Test','Test');
        foreach($tablecontents as $tablekey => $tableval)
        {
            // Check if the content contains any English text
            $isEnglish =self::containsEnglish($tableval);

            //english contains check only for tamil font
            if($language == 'ta')
            {
                // If content contains English, apply English font for that part
                if ($isEnglish) {
                    // Split the content into Tamil and English parts dynamically
                    $contentParts = preg_split('/([a-zA-Z]+)/', $tableval, -1, PREG_SPLIT_DELIM_CAPTURE);
                    $formattedContent = '';
    
                    // Loop through each part and apply the appropriate font (Tamil or English)
                    foreach ($contentParts as $part) {
                        if (preg_match('/[a-zA-Z]/', $part)) {
                            // Apply English font for English parts
                            $formattedContent .= '<span style="font-family: arial;">' . $part . '</span>';
                        } else {
                            // Apply Tamil font for Tamil parts
                            $formattedContent .= '<span style="font-family:'.$this->tamilfontname.';">' . $part . '</span>';
                        }
                    }
                } else {
                    // If no English text, use only Tamil font
                    $formattedContent = '<span style="font-family:'.$this->tamilfontname.';">' . $tableval . '</span>';
                }

            }else
            {
                $formattedContent = $tableval;
            }

            if ($tablekey == 'audit_director_letter_sideheading') {
                // Special row with colspan="5"
                $tabledata .= '<tr>
                                <td colspan="5" class="lang" style="text-align:center;">'.$formattedContent.'</td>
                            </tr>';
            } else 
            {
                $tabledata .= '<tr>
                                <td class="lang">'.$sno.'</td>
                                <td class="lang">'.$formattedContent.'</td>
                                <td class="lang">:</td>
                                <td class="fillupfield englishcontent">' . (isset($ValuesEcho[$x]) ? $ValuesEcho[$x] : '') . '</td>
                            </tr>';
                $sno++;
                $x++;
            }
        }

        // Create mPDF instance
        if($language == 'ta')
        {
            $mpdf = new Mpdf([
                'fontDir' => [public_path('fonts/Tamil')],  // Point mPDF to the directory of custom fonts
                'fontdata' => [
                    $this->tamilfontname => [
                        'R' => $this->tamilfontfile,  // Regular font
                    ],
                    'arial' => [
                        'R' => 'arial.ttf',  // Make sure to add Arial if you plan to use it for English content
                    ]
                ]
            ]);
            $fontfamily = $this->tamilfontname;

        }else
        {
            $mpdf = new Mpdf();
            $fontfamily = 'arial';
        }
    
        // Add a page
        $mpdf->AddPage();

        // Set the border properties (e.g., color, width)
        $mpdf->SetLineWidth(1); // Set the border width
        $mpdf->SetDrawColor(0, 0, 0); // Set the border color (Black)

        // Draw a border around the page (Rect(x, y, width, height))
        $mpdf->Rect(10, 10, 190, 277); // (X, Y, Width, Height)

        $htmlFilePath = resource_path('views/pdf/entryorexitmeeting.html'); // Adjust path as needed       
        $htmlContent = file_get_contents($htmlFilePath);

        $dynamicData =  [
                            'heading_title' => $title,
                            'fontFamily'    => $fontfamily,
                            'tabledata'     => $tabledata
                        ];

        // Replace placeholders with dynamic values
        foreach ($dynamicData as $key => $value) {
            $htmlContent = str_replace('{{' . $key . '}}', $value, $htmlContent);
        }

        // Write HTML content to the PDF
        $mpdf->WriteHTML($htmlContent);

        // Output the PDF to the browser
        return $mpdf->Output('entrymeeting.pdf', 'D');
    }

    public function exitmeeting(Request $request)
    {
        // Load content from JSON file
        $jsonFilePath = public_path('json/pdfcontent.json');        
        $jsonContent = file_get_contents($jsonFilePath);
        $data = json_decode($jsonContent, true);


        $language = $request->lang; //en or ta

        $title = $data['exitpdf_'.$language.'']['title'];

        $tablecontents =$data['exitpdf_'.$language.''];

        unset($tablecontents['title']);
        unset($tablecontents['autofillfield']);

        $tabledata = '';
        $sno = 1;
       
        foreach($tablecontents as $tablekey => $tableval)
        {
            // Check if the content contains any English text
            $isEnglish =self::containsEnglish($tableval);

            //english contains check only for tamil font
            if($language == 'ta')
            {
                // If content contains English, apply English font for that part
                if ($isEnglish) {
                    // Split the content into Tamil and English parts dynamically
                    $contentParts = preg_split('/([a-zA-Z]+)/', $tableval, -1, PREG_SPLIT_DELIM_CAPTURE);
                    $formattedContent = '';
    
                    // Loop through each part and apply the appropriate font (Tamil or English)
                    foreach ($contentParts as $part) {
                        if (preg_match('/[a-zA-Z]/', $part)) {
                            // Apply English font for English parts
                            $formattedContent .= '<span style="font-family: arial;">' . $part . '</span>';
                        } else {
                            // Apply Tamil font for Tamil parts
                            $formattedContent .= '<span style="font-family:'.$this->tamilfontname.';">' . $part . '</span>';
                        }
                    }
                } else {
                    // If no English text, use only Tamil font
                    $formattedContent = '<span style="font-family:'.$this->tamilfontname.';">' . $tableval . '</span>';
                }

            }else
            {
                $formattedContent = $tableval;
            }

            $Dataecho = ($tablekey == "auditor_details") ? $data['exitpdf_'.$language.'']['autofillfield'] : "-";


            if ($tablekey == 'auditor_details_sideheading') {
                // Special row with colspan="5"
                $tabledata .= '<tr>
                                <td colspan="5" class="lang" style="text-align:center;">'.$formattedContent.'</td>
                            </tr>';
            } else 
            {
                $tabledata .= '<tr>
                                <td class="lang">'.$sno.'</td>
                                <td class="lang">'.$formattedContent.'</td>
                                <td class="fillupfield">'.$Dataecho.'</td>
                            </tr>';
                $sno++;
            }
        }

        // Create mPDF instance
        if($language == 'ta')
        {
            $mpdf = new Mpdf([
                'fontDir' => [public_path('fonts/Tamil')],  // Point mPDF to the directory of custom fonts
                'fontdata' => [
                    $this->tamilfontname => [
                        'R' => $this->tamilfontfile,  // Regular font
                    ],
                    'arial' => [
                        'R' => 'arial.ttf',  // Make sure to add Arial if you plan to use it for English content
                    ]
                ]
            ]);
            $fontfamily = $this->tamilfontname;

        }else
        {
            $mpdf = new Mpdf();
            $fontfamily = 'arial';
        }
    
        // Add a page
        $mpdf->AddPage();

        // Set the border properties (e.g., color, width)
        $mpdf->SetLineWidth(1); // Set the border width
        $mpdf->SetDrawColor(0, 0, 0); // Set the border color (Black)

        // Draw a border around the page (Rect(x, y, width, height))
        $mpdf->Rect(10, 10, 190, 277); // (X, Y, Width, Height)

        $htmlFilePath = resource_path('views/pdf/entryorexitmeeting.html'); // Adjust path as needed       
        $htmlContent = file_get_contents($htmlFilePath);

        $dynamicData =  [
                            'heading_title' => $title,
                            'fontFamily'    => $fontfamily,
                            'tabledata'     => $tabledata
                        ];

        // Replace placeholders with dynamic values
        foreach ($dynamicData as $key => $value) {
            $htmlContent = str_replace('{{' . $key . '}}', $value, $htmlContent);
        }

        // Write HTML content to the PDF
        $mpdf->WriteHTML($htmlContent);

        // Output the PDF to the browser
        return $mpdf->Output('exitmeeting.pdf', 'D');
    }

    // Function to detect if a string contains any English characters
    public function containsEnglish($string) 
    {
        return preg_match('/[a-zA-Z]/', $string);  // Check for English letters
    }

    //for testing tamil pdf content 
    public function tamilcontentpdf(Request $request)
    {
         // Path to the Tamil font in your public/fonts directory
        $fontPath = public_path('fonts/tamil/FreeSerif.ttf'); // Replace with your Tamil font file path

        // Configure mPDF to use the Tamil font
        $mpdf = new Mpdf([
            'fontDir' => [public_path('fonts/tamil')], // Set the directory for the custom fonts
            'fontdata' => [
                'freeserif' => [
                    'R' => 'FreeSerif.ttf', // Regular font (use 'B' for Bold, 'I' for Italic, etc.)
                    
                ],
            ],
        ]);

        // Add a page
        $mpdf->AddPage();

        // Use the Tamil font in the content
        $htmlContent = '<div style="font-family: freeserif; font-size: 16px; direction: rtl;">';
        $htmlContent .= 'வணக்கம்! இது தமிழ் எழுத்து வடிவம் உள்ளது.';
        $htmlContent .= '</div>';

        utf8_encode($htmlContent);
        

        // Write HTML content to the PDF
        $mpdf->WriteHTML($htmlContent);

        // Output the PDF to the browser
        return $mpdf->Output('tamil_pdf_example.pdf', 'I');
    }


    public function previewgeneratepdf(Request $request)
    {
          // Initialize mPDF
          $mpdf = new \Mpdf\Mpdf();

           // Add a page
        $mpdf->AddPage();

        // Set the border properties (e.g., color, width)
        $mpdf->SetLineWidth(1); // Set the border width
        $mpdf->SetDrawColor(0, 0, 0); // Set the border color (Black)

        // Draw a border around the page (Rect(x, y, width, height))
        $mpdf->Rect(10, 10, 190, 277); // (X, Y, Width, Height)

          // HTML content for the PDF
          $html = '
              <html>
              <head>
                  <style>
                      body {
                          font-family:cursive;
                      }
                      .container {
                          border: 1px solid black;
                          padding: 20px;
                          margin: 10px;
                      }
                      .header {
                          text-align: center;
                          font-size: 24px;
                          font-weight: bold;
                      }
                      .content {
                          font-size: 18px;
                         text-align:center;

                      }
                      .footer {
                          text-align: right;
                          font-size: 14px;
                          margin-top: 30px;
                      }
                  </style>
              </head>
              <body>
                  <div class="container">
                      <div class="header">
                         ArulMigu Kapaleeshwarar temple, Mylapore, Chennai
                      </div>
                      <div class="content">
                          <p>Financial Year of 2024 - 2025</p>
                      </div>
                  </div>
                  <div class="part-a">
                    <h3>PART A</h3>
                    <ol>
                        <li><i class="fa fa-calendar text-warning me-2"></i>Intimation Letter</li>
                        <li><i class="fa fa-calendar text-warning me-2"></i>Entry Meeting</li>
                        <li><i class="fa fa-file text-info me-2"></i>Code Of Ethics</li>
                        <li><i class="fa fa-file text-info me-2"></i>Minute of Meeting</li>
                        <li><i class="fa fa-file text-info me-2"></i>Work Allocation</li>
                        <li><i class="fa fa-file text-info me-2"></i>Exit Meeting</li>
                    </ol>
                </div>

              </body>
              </html>
          ';
  
          // Write the HTML content to mPDF
          $mpdf->WriteHTML($html);

        $pdfContent = $mpdf->Output('', 'S');


        // Output the PDF to the browser
        //return $mpdf->Output('tamil_pdf_example.pdf', 'I');

         // Return Base64 encoded PDF
         return response()->json([
            'status' => 'success',
            'pdf' => base64_encode($pdfContent),
        ]);
    
    }


    
}
