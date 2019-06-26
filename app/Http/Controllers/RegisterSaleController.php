<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use Spatie\Async\Pool;

use \App\Models\Admin\Sale;

class RegisterSaleController extends Controller
{
    /**
     * Constants
     */
    const organization_key = 'organization_key_here'; //Enter your organization key
    const login_email    = 'email@namirial.api'; // Enter your namirail login email here
    
    const api_url = 'https://demo.xyzmo.com/Api/v4.0';
    const link_url = 'https://demo.xyzmo.com/SawViewer/SignAnyWhere.aspx';
    const public_url = 'http://mydoain.com'; // Enter your website doamin here
    const tmp_path = 'pdf_tmp/';
    const contract_document_path = 'signed_documents/';
    const template_document_file = 'template_documents/pdfafiescavuoto.pdf';
    const template_document_first_form = 'template_documents/firstone_new.pdf';
    const template_document_file_one = 'template_documents/afiesca-new.pdf';
    const template_document_file_two = 'template_documents/fwu-form-2.pdf';
    const template_document_file_three = 'template_documents/aglea-form-3.pdf';

    public function index(Request $request)
    {
        return view('registerSale.index');
    }
     
   public function detailed(Request $request)
   {
    return view('detailed');
   }
  
    /**
     * Register Sale And Envelope;Return Redirect URL
     */
    public function register_sale(Request $request)
    {
        if (Auth::check()) {

            $sale_data = $request->all();
            $sale = new Sale();
            $record_data = array_merge($sale_data['personalInfo'], $sale_data['questionnaire_data']);
            $sale->fill($record_data);
            $sale->age = $sale_data['age'];
            $sale->seller_id = Auth::user()->id;
            $sale->packageType = $sale_data['packageType'];
            $sale->price = $sale_data['price'];

            //Set Pending Status
            $sale->pending = 1;

            //Save Data without envelope_id to get ID
            $sale->save();
            //Prepare Sign
            $signDetail = self::prepare_sign($sale);

            $sale->envelope_id =  $signDetail['envelope_id'];

            //Save Data with envelope_id
            $sale->save();

            return response()->json(['success' => true, 'redirect' => $signDetail['redirectUrl']]);
        }
        return response()->json(['success' => false], 401);
    }

    public function register_questionnaire(Request $request)
    {

        if (Auth::check()) {
            $data = $request->all();
            // dd($data['idd_first_name']);
            //Generate PDF File
            $pdf = \PDF::loadView('registerSale.questionnaire', $data);
            //return $pdf->stream('invoice.pdf');

            // $file_name = uniqid();
            $file_name = 'myfilename';
            // $pdf->setWarnings(false)->save(self::tmp_path . $file_name . '.pdf');
            $pdf->setWarnings(false)->save(self::tmp_path . $file_name . '.pdf');

            //Get Full Path of Generated PDF File
            $file_full_path = public_path(self::tmp_path . $file_name . '.pdf');

            //Send Email With Attachment
            \Mail::send('registerSale.mail', ['name'=> $data['idd_first_name'] . ' ' . $data['idd_last_name']], function($message) use ($data, $file_full_path){
                $message->to($data['idd_email'], 'AssyTech')->subject
                    ('Risultato per la tua assicurazione');
                $message->attach($file_full_path);
                $message->from('noreply@gmail.com','AssyTech');
            });

            unlink($file_full_path);


            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }
     
    public function register_first_salesform(Request $request)
    {   

        $sale_data = $request->all();
        $firstForm['familiariDaGarantire'] = serialize($sale_data);
        $sale = new Sale();
        $sale->fill($firstForm);
        $sale->age =0;
        $sale->seller_id = Auth::user()->id;
        $sale->price = 0;
        //Set Pending Status
        //Save Data without envelope_id to get ID
        $sale->save();
        // Prepare Sign
        $sale_data['id'] = $sale->id;
        $signDetail = self::prepare_sign_first_form($sale_data);
        $sale->envelope_id =  $signDetail['envelope_id'][0];
        // Save Data with envelope_id
        $sale->save();
        return response()->json(['success' => true, 'redirect' => $signDetail['redirectUrl']]);

      
    }

    /**
     * Reg Successful page, update pending status for sale
     */
    public function reg_successfull(Request $request)
    {
        //Update Pending Status
        $sale_id = $request->sale_id;

        if( is_null($sale_id) )
            exit;

        $sale = Sale::find($sale_id);

        //Update Sale Status
        $sale->pending = 0;

        if($sale->save())
            return view('regSuccessfull', ['sale_id' => $sale->id]);

        echo "Something went wrong...";
    }
      
    public function reg_successfull_first_form(Request $request)
    {
        echo "Test";
    }


    /**
     * Download completed Document in the background
     */
    public function download_finished_document_background(Request $request)
    {
        $sale_id = $request->sale_id;

        if( is_null($sale_id) )
            exit;

        $sale = Sale::find($sale_id);

        while(1)
        {
            //Save Finished Document
            $Envelopes = array(
                self::namirialGetEnvelope($sale->envelope_id),
                self::namirialGetEnvelope($sale->envelope_id_two),
                self::namirialGetEnvelope($sale->envelope_id_three),
            );
            $i = 1;
            foreach ($Envelopes as $Envelope) {
                if(count($Envelope->Bulks[0]->FinishedDocuments) > 0) {
                    $generatedFile = self::namirialDownloadDocument($Envelope->Bulks[0]->FinishedDocuments[0]->FlowDocumentId, $sale->id . '-' . $i . ".pdf");
                    //Send Email With Attachment
                    \Mail::send('registerSale.contractMail', ['name'=> $sale->idd_first_name . ' ' . $sale->idd_last_name], function($message) use ($sale, $generatedFile){
                        $message->to($sale->idd_email, 'AssyTech')->subject
                            ('AssyTech - il tuo contratto');
                        $message->attach($generatedFile);
                        $message->from('noreply@gmail.com','AssyTech');
                    });
                }
                $i++;
            }
            return;
            sleep(5);
        }
    }

    /**
     * Download Finished Document
     */
    public function download_document(Request $request)
    {
        if (Auth::check()) {
            $sale_id = $request->sale_id;
            $filename = self::contract_document_path . $sale_id . '.pdf';
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false); // required for certain browsers
            header('Content-Type: application/pdf');

            header('Content-Disposition: attachment; filename="'. basename('SignedDocument.pdf') . '";');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($filename));

            readfile($filename);

            exit;
        }
    }

    /**
     * Test Envelope Status
     */
    public function esign_test(Request $request)
    {
        $SspFileId = self::namirialUploadTemporarySspFile_v1('pdf_tmp/test.pdf');

        $preTasks = self::namirialGetPreparedTasks($SspFileId);

        $EnvelopeId = self::namirialSendEnvelope($SspFileId, $preTasks);

        $Envelop = self::namirialGetEnvelope($EnvelopeId);

        $WorkstepRedirectionUrl = $Envelop->Bulks[0]->Steps[0]->WorkstepRedirectionUrl;

        $WorkstepId = self::namirialGetWorkstepId($WorkstepRedirectionUrl);

        //$ioslink = self::namirialGetRedirectToIos($WorkstepRedirectionUrl);

        $DocumentRedirectLink = self::link_url . '?WorkstepId=' . $WorkstepId . '&setLng=it';
        echo $DocumentRedirectLink;
    }

    /**
     * Log Envelope Event
     */
    public function event_log(Request $request)
    {

        $envelope   = $request->envelope;
        $action   = $request->action;
        $internalid   = $request->internalid;

        $myfile = fopen("pdf_tmp/logs.txt", "a") or die("Unable to open file!");
        $txt = $envelope . '     ' . $action . '     ' . $internalid . '\n';
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
    }

    /**
     * Prepare Sign
     */
    public static function prepare_sign($sale)
    {

        $pdfUrlOne = self::generateSignPDFFormOne($sale);

        $pdfUrlTwo = self::generateSignPDFFormTwo($sale);

        $pdfUrlThree = self::generateSignPDFFormThree($sale);

        // dd("pdf created please check public testing directory");

        /* old function for writing on first pdf */
        // $pdfUrl = self::generateSignPDF($sale);

        // $SspFileId = self::namirialUploadTemporarySspFile_v1($pdfUrl);


        $SspFileId = self::namirialUploadTemporarySspFile_v1($pdfUrlOne);

        $preTasks = self::namirialGetPreparedTasks($SspFileId);

        $EnvelopeId = self::namirialSendEnvelope($SspFileId, $preTasks, $sale);

        $Envelop = self::namirialGetEnvelope($EnvelopeId);

        $WorkstepRedirectionUrl = $Envelop->Bulks[0]->Steps[0]->WorkstepRedirectionUrl;

        $WorkstepId = self::namirialGetWorkstepId($WorkstepRedirectionUrl);

        $DocumentRedirectLink = self::link_url . '?WorkstepId=' . $WorkstepId . '&setLng=it';




        $SspFileIdTwo = self::namirialUploadTemporarySspFile_v1($pdfUrlTwo);

        $preTasksTwo = self::namirialGetPreparedTasks($SspFileIdTwo);

        $EnvelopeIdTwo = self::namirialSendEnvelope($SspFileIdTwo, $preTasksTwo, $sale);

        $EnvelopTwo = self::namirialGetEnvelope($EnvelopeIdTwo);

        $WorkstepRedirectionUrlTwo = $EnvelopTwo->Bulks[0]->Steps[0]->WorkstepRedirectionUrl;

        $WorkstepIdTwo = self::namirialGetWorkstepId($WorkstepRedirectionUrlTwo);

        $DocumentRedirectLinkTwo = self::link_url . '?WorkstepId=' . $WorkstepIdTwo . '&setLng=it';




        $SspFileIdThree = self::namirialUploadTemporarySspFile_v1($pdfUrlThree);

        $preTasksThree = self::namirialGetPreparedTasks($SspFileIdThree);

        $EnvelopeIdThree = self::namirialSendEnvelope($SspFileIdThree, $preTasksThree, $sale);

        $EnvelopThree = self::namirialGetEnvelope($EnvelopeIdThree);

        $WorkstepRedirectionUrlThree = $EnvelopThree->Bulks[0]->Steps[0]->WorkstepRedirectionUrl;

        $WorkstepIdThree = self::namirialGetWorkstepId($WorkstepRedirectionUrlThree);

        $DocumentRedirectLinkThree = self::link_url . '?WorkstepId=' . $WorkstepIdThree . '&setLng=it';


        return [
            'redirectUrl' => [$DocumentRedirectLink, $DocumentRedirectLinkTwo, $DocumentRedirectLinkThree], 
            'envelope_id' => [$EnvelopeId, $EnvelopeIdTwo, $EnvelopeIdThree]
        ];
    }
     
    public static function prepare_sign_first_form($sale)
    {
        $pdfUrl = self::generateSignPDFForm($sale);

        // dd("pdf created please check public testing directory");

        /* old function for writing on first pdf */
        // $pdfUrl = self::generateSignPDF($sale);

        $SspFileId = self::namirialUploadTemporarySspFile_v1($pdfUrl);


        $preTasks = self::namirialGetPreparedTasks($SspFileId);
          
        $EnvelopeId = self::FormOnenamirialSendEnvelope($SspFileId, $preTasks, $sale);
        $Envelop = self::namirialGetEnvelope($EnvelopeId);
        $WorkstepRedirectionUrl = $Envelop->Bulks[0]->Steps[0]->WorkstepRedirectionUrl;

        $WorkstepId = self::namirialGetWorkstepId($WorkstepRedirectionUrl);

        $DocumentRedirectLink = self::link_url . '?WorkstepId=' . $WorkstepId . '&setLng=it';



        return [
            'redirectUrl' => [$DocumentRedirectLink], 
            'envelope_id' => [$EnvelopeId]
        ];
    }


    public static function namirialAuthroize()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::api_url . '/authorization',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER  => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $httpcode;
    }

    public static function namirialUploadTemporarySspFile_v1($file_name)
    {
        $curlFILE = curl_init ();
        // dd();
        curl_setopt_array ( $curlFILE, array (
            CURLOPT_URL => self::api_url . '/sspfile/uploadtemporary',
            CURLOPT_HTTPHEADER => array (
                'accept: application/json',
                'Content-Type: multipart/form-data',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => array (
                'File' => new \CURLFile ( $file_name )
            )
        ) );

        $response = json_decode(curl_exec($curlFILE));
        $err = curl_error($curlFILE);
        // dd($response);
        if($err)
        {
            return false;
        }
        curl_close($curlFILE);
        return $response->SspFileId;
    }

    public static function namirialSendEnvelope($SspFileId, $preTasks, $sale)
    {
        $envelopeModel = [
            "SspFileIds" => [
              $SspFileId
            ],
            "SendEnvelopeDescription" => [
                "Steps" => [
                    [
                        "OrderIndex" => 0,
                        "RecipientType" => "Signer",
                        "Recipients" => [
                            [
                                "Email" => $sale['questionnaire_data']['idd_email'],
                                "FirstName" => $sale['questionnaire_data']['idd_first_name'],
                                "LastName" => $sale['questionnaire_data']['idd_last_name'],
                                'DisableEmail' => true
                            ]
                        ],
                        "WorkstepConfiguration" => [
                            "WorkstepLabel" => 'workstep label',
                            "WorkstepTimeToLiveInMinutes" => 30,
                            "Policy" => [
                                "WorkstepTasks" => [
                                    "Tasks" => $preTasks
                                ]
                            ],
                            "FinishAction"=> [
                                "ClientActions"=> [
                                  [
                                    "RemoveDocumentFromRecentDocumentList"=> true,
                                    "CallClientActionOnlyAfterSuccessfulSync"=> true,
                                    "ClientName"=> "SIGNificant SignAnywhere",
                                    "CloseApp"=> false,
                                    "Action"=> self::public_url . "/reg_successfull?sale_id=" . $sale['id']
                                  ]
                                ]
                            ],
                        ],

                    ]
                ],
                "StatusUpdateCallbackUrl" => self::public_url . "/log?envelope=##EnvelopeId##&action=##Action##&internalid=" . $sale['id'],
                "Name" => "AssyTech Contract",
                "EmailSubject" => "Our contract",
                "EmailBody" => "Hey please sign the document",
                "DisplayedEmailSender" => "AssyTech",
                "EnableReminders" => false,
                "FirstReminderDayAmount"=> 0,
                "RecurrentReminderDayAmount"=> 0,
                "BeforeExpirationDayAmount"=> 0,
                "DaysUntilExpire"=> 1,
            ]
        ];
        $curl = curl_init ();
        curl_setopt_array ( $curl, array (
            CURLOPT_URL => self::api_url . '/envelope/send',
            CURLOPT_HTTPHEADER => array (
                'accept: application/json',
                'Content-Type: application/json',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => json_encode($envelopeModel)
        ) );
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        if($err)
        {
            return false;
        }
        curl_close($curl);
        
        return $response->EnvelopeId;
    }
    
    
    public static function FormOnenamirialSendEnvelope($SspFileId, $preTasks, $sale)
    {
        //dd();
        $envelopeModel = [
            "SspFileIds" => [
              $SspFileId
            ],
            "SendEnvelopeDescription" => [
                "Steps" => [
                    [
                        "OrderIndex" => 0,
                        "RecipientType" => "Signer",
                        "Recipients" => [
                            [
                                "FirstName" => Auth::user()->first_name,
                                "LastName" => Auth::user()->last_name,
                                "email"    =>Auth::user()->email
                            ]
                        ],
                        "WorkstepConfiguration" => [
                            "WorkstepLabel" => 'workstep label',
                            "WorkstepTimeToLiveInMinutes" => 30,
                            "Policy" => [
                                "WorkstepTasks" => [
                                    "Tasks" => $preTasks
                                ]
                            ],
                            "FinishAction"=> [
                                "ClientActions"=> [
                                  [
                                    "RemoveDocumentFromRecentDocumentList"=> true,
                                    "CallClientActionOnlyAfterSuccessfulSync"=> true,
                                    "ClientName"=> "SIGNificant SignAnywhere",
                                    "CloseApp"=> false,
                                    "Action"=> self::public_url . "/detailed"
                                  ]
                                ]
                            ],
                        ],

                    ]
                ],
                "StatusUpdateCallbackUrl" => self::public_url . "/log?envelope=##EnvelopeId##&action=##Action##&internalid=" . $sale['id'],
                "Name" => "AssyTech Contract",
                "EmailSubject" => "Our contract",
                "EmailBody" => "Hey please sign the document",
                "DisplayedEmailSender" => "AssyTech",
                "EnableReminders" => false,
                "FirstReminderDayAmount"=> 0,
                "RecurrentReminderDayAmount"=> 0,
                "BeforeExpirationDayAmount"=> 0,
                "DaysUntilExpire"=> 1,
            ]
            ];
        $curl = curl_init ();
        curl_setopt_array ( $curl, array (
            CURLOPT_URL => self::api_url . '/envelope/send',
            CURLOPT_HTTPHEADER => array (
                'accept: application/json',
                'Content-Type: application/json',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => json_encode($envelopeModel)
        ) );
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);
        if($err)
        {
            return false;
        }
        curl_close($curl);
        return $response->EnvelopeId;
    }
     
    public static function namirialGetEnvelope($EnvelopeId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::api_url . '/envelope/' . $EnvelopeId,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
        ));
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        if($err)
        {
            return false;
        }
        curl_close($curl);
        return $response;
    }

    public static function namirialGetWorkstepId($WorkstepRedirectionUrl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $WorkstepRedirectionUrl . "&responseType=returnWorkstepId",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err)
        {
            return false;
        }
        curl_close($curl);
        return $response;
    }

    public static function namirialGetRedirectToIos($WorkstepRedirectionUrl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $WorkstepRedirectionUrl . "&responseType=redirectToAndroidApp",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err)
        {
            return false;
        }
        curl_close($curl);
        return $response;
    }

    public static function namirialGetPreparedTasks($SspFileId)
    {
        // dd($SspFileId);
        $prepareEnvelopeModel = [
            "SspFileIds" => [
                $SspFileId
            ],
            "AdHocWorkstepConfiguration" => [
                "WorkstepLabel" => "Work Step Label",
                "SmallTextZoomFactorPercent" => 100,
                "WorkstepTimeToLiveInMinutes" => 30
            ]
        ];
        $curl = curl_init ();
        curl_setopt_array ( $curl, array (
            CURLOPT_URL => self::api_url . '/envelope/prepare',
            CURLOPT_HTTPHEADER => array (
                'accept: application/json',
                'Content-Type: application/json',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => json_encode($prepareEnvelopeModel)
        ) );
        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);
        if($err)
        {
            return false;
        }
        curl_close($curl);

        $tasks = $response->AdHocWorkstepConfigResult->Policy->WorkstepTasks->Tasks;
        for($i = 0; $i < count($tasks); $i++)
        {
            $tasks[$i]->AllowedSignatureTypes = [
                [
                    "DiscriminatorType" => "SigTypeDraw2Sign",
                    "Preferred" => true
                ]
            ];
            $tasks[$i]->Size = [
                "Width" => 120,
                "Height" => 20
            ];
        }
        return $tasks;
    }

    public static function namirialDownloadDocument($DocumentId, $fileName)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::api_url . '/envelope/downloadCompletedDocument/' . $DocumentId,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'accept: application/octet-stream',
                'organizationKey: ' . self::organization_key,
                'userLoginName: ' . self::login_email
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err)
        {
            return false;
        }
        curl_close($curl);

        $documentFile = fopen(self::contract_document_path . $fileName, "w") or die("Unable to open file!");
        fwrite($documentFile, $response);
        fclose($documentFile);

        return self::contract_document_path . $fileName;
    }

    public static function generateSignPDF($sale)
    {
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile(self::template_document_file);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);

            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);



            if($pageNo == 1)
            {
                //Output Name
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6.5);
                $pdf->SetXY(45, 57.3);
                // $pdf->Write(5, $sale->idd_first_name . ' ' . $sale->idd_last_name);
            }
            else if($pageNo == 2)
            {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(5);
                $current_location = self::get_client_location();

                $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                //Output Current Date
                $pdf->SetXY(30, 73.2);
                $pdf->Write(5, $date_location_str);

                $pdf->SetXY(30, 109);
                $pdf->Write(5, $date_location_str);
            }
        }

        // Output the new PDF
        $file_name = uniqid();

        $pdf->Output(self::tmp_path . $file_name . '.pdf','F');

        //Get Full Path of Generated PDF File
        $file_full_path = public_path(self::tmp_path . $file_name . '.pdf');

        return $file_full_path;
    }

    public static function get_client_location() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        if($ipaddress == '127.0.0.1')
            $ipaddress = '185.57.29.193';
        $json  = file_get_contents("http://ip-api.com/json/$ipaddress");
        $json  =  json_decode($json ,true);

        return $json;
    }
    public static function countryCodeToCountry($code) {
        $code = strtoupper($code);
        if ($code == 'AF') return 'Afghanistan';
        if ($code == 'AX') return 'Aland Islands';
        if ($code == 'AL') return 'Albania';
        if ($code == 'DZ') return 'Algeria';
        if ($code == 'AS') return 'American Samoa';
        if ($code == 'AD') return 'Andorra';
        if ($code == 'AO') return 'Angola';
        if ($code == 'AI') return 'Anguilla';
        if ($code == 'AQ') return 'Antarctica';
        if ($code == 'AG') return 'Antigua and Barbuda';
        if ($code == 'AR') return 'Argentina';
        if ($code == 'AM') return 'Armenia';
        if ($code == 'AW') return 'Aruba';
        if ($code == 'AU') return 'Australia';
        if ($code == 'AT') return 'Austria';
        if ($code == 'AZ') return 'Azerbaijan';
        if ($code == 'BS') return 'Bahamas the';
        if ($code == 'BH') return 'Bahrain';
        if ($code == 'BD') return 'Bangladesh';
        if ($code == 'BB') return 'Barbados';
        if ($code == 'BY') return 'Belarus';
        if ($code == 'BE') return 'Belgium';
        if ($code == 'BZ') return 'Belize';
        if ($code == 'BJ') return 'Benin';
        if ($code == 'BM') return 'Bermuda';
        if ($code == 'BT') return 'Bhutan';
        if ($code == 'BO') return 'Bolivia';
        if ($code == 'BA') return 'Bosnia and Herzegovina';
        if ($code == 'BW') return 'Botswana';
        if ($code == 'BV') return 'Bouvet Island (Bouvetoya)';
        if ($code == 'BR') return 'Brazil';
        if ($code == 'IO') return 'British Indian Ocean Territory (Chagos Archipelago)';
        if ($code == 'VG') return 'British Virgin Islands';
        if ($code == 'BN') return 'Brunei Darussalam';
        if ($code == 'BG') return 'Bulgaria';
        if ($code == 'BF') return 'Burkina Faso';
        if ($code == 'BI') return 'Burundi';
        if ($code == 'KH') return 'Cambodia';
        if ($code == 'CM') return 'Cameroon';
        if ($code == 'CA') return 'Canada';
        if ($code == 'CV') return 'Cape Verde';
        if ($code == 'KY') return 'Cayman Islands';
        if ($code == 'CF') return 'Central African Republic';
        if ($code == 'TD') return 'Chad';
        if ($code == 'CL') return 'Chile';
        if ($code == 'CN') return 'China';
        if ($code == 'CX') return 'Christmas Island';
        if ($code == 'CC') return 'Cocos (Keeling) Islands';
        if ($code == 'CO') return 'Colombia';
        if ($code == 'KM') return 'Comoros the';
        if ($code == 'CD') return 'Congo';
        if ($code == 'CG') return 'Congo the';
        if ($code == 'CK') return 'Cook Islands';
        if ($code == 'CR') return 'Costa Rica';
        if ($code == 'CI') return 'Cote d\'Ivoire';
        if ($code == 'HR') return 'Croatia';
        if ($code == 'CU') return 'Cuba';
        if ($code == 'CY') return 'Cyprus';
        if ($code == 'CZ') return 'Czech Republic';
        if ($code == 'DK') return 'Denmark';
        if ($code == 'DJ') return 'Djibouti';
        if ($code == 'DM') return 'Dominica';
        if ($code == 'DO') return 'Dominican Republic';
        if ($code == 'EC') return 'Ecuador';
        if ($code == 'EG') return 'Egypt';
        if ($code == 'SV') return 'El Salvador';
        if ($code == 'GQ') return 'Equatorial Guinea';
        if ($code == 'ER') return 'Eritrea';
        if ($code == 'EE') return 'Estonia';
        if ($code == 'ET') return 'Ethiopia';
        if ($code == 'FO') return 'Faroe Islands';
        if ($code == 'FK') return 'Falkland Islands (Malvinas)';
        if ($code == 'FJ') return 'Fiji the Fiji Islands';
        if ($code == 'FI') return 'Finland';
        if ($code == 'FR') return 'France, French Republic';
        if ($code == 'GF') return 'French Guiana';
        if ($code == 'PF') return 'French Polynesia';
        if ($code == 'TF') return 'French Southern Territories';
        if ($code == 'GA') return 'Gabon';
        if ($code == 'GM') return 'Gambia the';
        if ($code == 'GE') return 'Georgia';
        if ($code == 'DE') return 'Germany';
        if ($code == 'GH') return 'Ghana';
        if ($code == 'GI') return 'Gibraltar';
        if ($code == 'GR') return 'Greece';
        if ($code == 'GL') return 'Greenland';
        if ($code == 'GD') return 'Grenada';
        if ($code == 'GP') return 'Guadeloupe';
        if ($code == 'GU') return 'Guam';
        if ($code == 'GT') return 'Guatemala';
        if ($code == 'GG') return 'Guernsey';
        if ($code == 'GN') return 'Guinea';
        if ($code == 'GW') return 'Guinea-Bissau';
        if ($code == 'GY') return 'Guyana';
        if ($code == 'HT') return 'Haiti';
        if ($code == 'HM') return 'Heard Island and McDonald Islands';
        if ($code == 'VA') return 'Holy See (Vatican City State)';
        if ($code == 'HN') return 'Honduras';
        if ($code == 'HK') return 'Hong Kong';
        if ($code == 'HU') return 'Hungary';
        if ($code == 'IS') return 'Iceland';
        if ($code == 'IN') return 'India';
        if ($code == 'ID') return 'Indonesia';
        if ($code == 'IR') return 'Iran';
        if ($code == 'IQ') return 'Iraq';
        if ($code == 'IE') return 'Ireland';
        if ($code == 'IM') return 'Isle of Man';
        if ($code == 'IL') return 'Israel';
        if ($code == 'IT') return 'Italy';
        if ($code == 'JM') return 'Jamaica';
        if ($code == 'JP') return 'Japan';
        if ($code == 'JE') return 'Jersey';
        if ($code == 'JO') return 'Jordan';
        if ($code == 'KZ') return 'Kazakhstan';
        if ($code == 'KE') return 'Kenya';
        if ($code == 'KI') return 'Kiribati';
        if ($code == 'KP') return 'Korea';
        if ($code == 'KR') return 'Korea';
        if ($code == 'KW') return 'Kuwait';
        if ($code == 'KG') return 'Kyrgyz Republic';
        if ($code == 'LA') return 'Lao';
        if ($code == 'LV') return 'Latvia';
        if ($code == 'LB') return 'Lebanon';
        if ($code == 'LS') return 'Lesotho';
        if ($code == 'LR') return 'Liberia';
        if ($code == 'LY') return 'Libyan Arab Jamahiriya';
        if ($code == 'LI') return 'Liechtenstein';
        if ($code == 'LT') return 'Lithuania';
        if ($code == 'LU') return 'Luxembourg';
        if ($code == 'MO') return 'Macao';
        if ($code == 'MK') return 'Macedonia';
        if ($code == 'MG') return 'Madagascar';
        if ($code == 'MW') return 'Malawi';
        if ($code == 'MY') return 'Malaysia';
        if ($code == 'MV') return 'Maldives';
        if ($code == 'ML') return 'Mali';
        if ($code == 'MT') return 'Malta';
        if ($code == 'MH') return 'Marshall Islands';
        if ($code == 'MQ') return 'Martinique';
        if ($code == 'MR') return 'Mauritania';
        if ($code == 'MU') return 'Mauritius';
        if ($code == 'YT') return 'Mayotte';
        if ($code == 'MX') return 'Mexico';
        if ($code == 'FM') return 'Micronesia';
        if ($code == 'MD') return 'Moldova';
        if ($code == 'MC') return 'Monaco';
        if ($code == 'MN') return 'Mongolia';
        if ($code == 'ME') return 'Montenegro';
        if ($code == 'MS') return 'Montserrat';
        if ($code == 'MA') return 'Morocco';
        if ($code == 'MZ') return 'Mozambique';
        if ($code == 'MM') return 'Myanmar';
        if ($code == 'NA') return 'Namibia';
        if ($code == 'NR') return 'Nauru';
        if ($code == 'NP') return 'Nepal';
        if ($code == 'AN') return 'Netherlands Antilles';
        if ($code == 'NL') return 'Netherlands the';
        if ($code == 'NC') return 'New Caledonia';
        if ($code == 'NZ') return 'New Zealand';
        if ($code == 'NI') return 'Nicaragua';
        if ($code == 'NE') return 'Niger';
        if ($code == 'NG') return 'Nigeria';
        if ($code == 'NU') return 'Niue';
        if ($code == 'NF') return 'Norfolk Island';
        if ($code == 'MP') return 'Northern Mariana Islands';
        if ($code == 'NO') return 'Norway';
        if ($code == 'OM') return 'Oman';
        if ($code == 'PK') return 'Pakistan';
        if ($code == 'PW') return 'Palau';
        if ($code == 'PS') return 'Palestinian Territory';
        if ($code == 'PA') return 'Panama';
        if ($code == 'PG') return 'Papua New Guinea';
        if ($code == 'PY') return 'Paraguay';
        if ($code == 'PE') return 'Peru';
        if ($code == 'PH') return 'Philippines';
        if ($code == 'PN') return 'Pitcairn Islands';
        if ($code == 'PL') return 'Poland';
        if ($code == 'PT') return 'Portugal, Portuguese Republic';
        if ($code == 'PR') return 'Puerto Rico';
        if ($code == 'QA') return 'Qatar';
        if ($code == 'RE') return 'Reunion';
        if ($code == 'RO') return 'Romania';
        if ($code == 'RU') return 'Russian Federation';
        if ($code == 'RW') return 'Rwanda';
        if ($code == 'BL') return 'Saint Barthelemy';
        if ($code == 'SH') return 'Saint Helena';
        if ($code == 'KN') return 'Saint Kitts and Nevis';
        if ($code == 'LC') return 'Saint Lucia';
        if ($code == 'MF') return 'Saint Martin';
        if ($code == 'PM') return 'Saint Pierre and Miquelon';
        if ($code == 'VC') return 'Saint Vincent and the Grenadines';
        if ($code == 'WS') return 'Samoa';
        if ($code == 'SM') return 'San Marino';
        if ($code == 'ST') return 'Sao Tome and Principe';
        if ($code == 'SA') return 'Saudi Arabia';
        if ($code == 'SN') return 'Senegal';
        if ($code == 'RS') return 'Serbia';
        if ($code == 'SC') return 'Seychelles';
        if ($code == 'SL') return 'Sierra Leone';
        if ($code == 'SG') return 'Singapore';
        if ($code == 'SK') return 'Slovakia (Slovak Republic)';
        if ($code == 'SI') return 'Slovenia';
        if ($code == 'SB') return 'Solomon Islands';
        if ($code == 'SO') return 'Somalia, Somali Republic';
        if ($code == 'ZA') return 'South Africa';
        if ($code == 'GS') return 'South Georgia and the South Sandwich Islands';
        if ($code == 'ES') return 'Spain';
        if ($code == 'LK') return 'Sri Lanka';
        if ($code == 'SD') return 'Sudan';
        if ($code == 'SR') return 'Suriname';
        if ($code == 'SJ') return 'Svalbard & Jan Mayen Islands';
        if ($code == 'SZ') return 'Swaziland';
        if ($code == 'SE') return 'Sweden';
        if ($code == 'CH') return 'Switzerland, Swiss Confederation';
        if ($code == 'SY') return 'Syrian Arab Republic';
        if ($code == 'TW') return 'Taiwan';
        if ($code == 'TJ') return 'Tajikistan';
        if ($code == 'TZ') return 'Tanzania';
        if ($code == 'TH') return 'Thailand';
        if ($code == 'TL') return 'Timor-Leste';
        if ($code == 'TG') return 'Togo';
        if ($code == 'TK') return 'Tokelau';
        if ($code == 'TO') return 'Tonga';
        if ($code == 'TT') return 'Trinidad and Tobago';
        if ($code == 'TN') return 'Tunisia';
        if ($code == 'TR') return 'Turkey';
        if ($code == 'TM') return 'Turkmenistan';
        if ($code == 'TC') return 'Turks and Caicos Islands';
        if ($code == 'TV') return 'Tuvalu';
        if ($code == 'UG') return 'Uganda';
        if ($code == 'UA') return 'Ukraine';
        if ($code == 'AE') return 'United Arab Emirates';
        if ($code == 'GB') return 'United Kingdom';
        if ($code == 'US') return 'United States of America';
        if ($code == 'UM') return 'United States Minor Outlying Islands';
        if ($code == 'VI') return 'United States Virgin Islands';
        if ($code == 'UY') return 'Uruguay, Eastern Republic of';
        if ($code == 'UZ') return 'Uzbekistan';
        if ($code == 'VU') return 'Vanuatu';
        if ($code == 'VE') return 'Venezuela';
        if ($code == 'VN') return 'Vietnam';
        if ($code == 'WF') return 'Wallis and Futuna';
        if ($code == 'EH') return 'Western Sahara';
        if ($code == 'YE') return 'Yemen';
        if ($code == 'XK') return 'Kosovo';
        if ($code == 'ZM') return 'Zambia';
        if ($code == 'ZW') return 'Zimbabwe';
        return '';
    }





    /**
     * Register sale without auth for testing
     */

    public function register_sale_test(Request $request)
    {
        $sale_data = $request->all();
        $personalInfo['personalInfo'] = serialize($sale_data['personalInfo']);
        $sale = new Sale();
        $record_data = array_merge($personalInfo, $sale_data['questionnaire_data']);
        $sale->fill($record_data);
        $sale->age = $sale_data['age'];
        $sale->seller_id = Auth::user()->id;
        $sale->packageType = $sale_data['packageType'];
        $sale->price = $sale_data['price'];
        //Set Pending Status
        $sale->pending = 1;
        //Save Data without envelope_id to get ID
        $sale->save();
        //Prepare Sign
        $sale_data['id'] = $sale->id;
        $signDetail = self::prepare_sign($sale_data);
        $sale->envelope_id =  $signDetail['envelope_id'][0];
        $sale->envelope_id_two =  $signDetail['envelope_id'][1];
        $sale->envelope_id_three =  $signDetail['envelope_id'][2];
        // Save Data with envelope_id
        $sale->save();
        return response()->json(['success' => true, 'redirect' => $signDetail['redirectUrl']]);
    }




    /**
     * Write infomation on PDF file with cordinates form two
     * 
     */


    public static function generateSignPDFFormTwo($sale)
    {
        $pageOne = $sale['personalInfo']['formTwo'];
        $pageTwo = $sale['personalInfo']['formTwo']['pageTwo'];
        $pageThree = $sale['personalInfo']['formTwo']['pageThree'];
        $pdf = new \setasign\Fpdi\Fpdi();
        $date = date('Y-m-d');
        $pageCount = $pdf->setSourceFile(self::template_document_file_two);
        $pdf->SetAutoPageBreak(TRUE, 0);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }
            // use the imported page
            $pdf->useTemplate($templateId);
            if($pageNo == 1)
            {
                //Output Name
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(5.5);
                $cordinates = array(
                    array(16.76, 55.5, $pageOne['PropostaNumero']),//Proposta Numero
                    array(61.47, 55.5, $pageOne['Agenzia']),//Agenzia
                    array(105.16, 55.5, $pageOne['Codiceagenzia']),//Codice agenzia
                    array(147.83, 55.5, $pageOne['Codiceintermediario']),//Codice intermediario
                    array(58.67, 69, $pageOne['Contraente']['Sig']),//Cognome, nome /Ragione Sociale //Sig.
                    array(65.53, 69, $pageOne['Contraente']['Sigra']),//Sig.ra
                    array(72.39, 69, $pageOne['Contraente']['Soc']),//Soc.
                    array(82.04, 69, $pageOne['Contraente']['Cognome']),//Cognome / Ragione Sociale
                    array(135.64, 69, $pageOne['Contraente']['Nome']),//Nome
                    array(60.71, 76.45, $pageOne['Contraente']['Indirizzo']),//Residenza / Sede legale //Indirizzo
                    array(174.75, 76.45, $pageOne['Contraente']['Numero']),//Numero
                    array(59.18, 82.8, $pageOne['Contraente']['CAP']),//CAP
                    array(81.03, 82.8, $pageOne['Contraente']['Città']),//Città
                    array(135.13, 82.8, $pageOne['Contraente']['Provincia']),//Provincia
                    array(59.69, 89.15, $pageOne['Contraente']['Datadinascita']),//Data e luogo di nascita //Data di nascita
                    array(81.53, 89.15, $pageOne['Contraente']['Luogodinascita']),//Luogo di nascita
                    array(134.62, 89.15, $pageOne['Contraente']['Provincia2']),//Provincia
                    array(156.97, 89.15, $pageOne['Contraente']['Statodinascita']),//Stato di nascita
                    array(58.93, 96.01, $pageOne['Contraente']['Nazionalita']),//Nazionalità / Professione attuale e settore economico //Italiana
                    array(81.53, 96.01, ""), //Altra nazionalità
                    array(124.21, 96.01, $pageOne['Contraente']['Professione']),//Professione
                    array(156.46, 96.01, $pageOne['Contraente']['Settoreeconomico']),//Settore economico
                    
                    array(96.52, 101.85, $pageOne['Contraente']['Specificarela']),//Specifi care la Nazione di cui il Contraente è contribuente fi scale
                    array(156.97, 101.85, $pageOne['Contraente']['Identificativo']),//Identifi cativo fi scale (TIN/NIF)
                    array(59.94, 108.2, $pageOne['Contraente']['Codicefiscale']),//Codice fi scale / Partita IVA //Codice fi scale
                    array(124.97, 108.2, $pageOne['Contraente']['PartitaIVA']),//Partita IVA
                    array(59.94, 114.3, $pageOne['Contraente']['Indirizzo2']),//Recapito di contatto //Indirizzo
                    array(174.75, 114.3, $pageOne['Contraente']['Numero2']),//Numero
                    array(59.18, 120.4, $pageOne['Contraente']['CAP2']),//CAP
                    array(81.28, 120.4, $pageOne['Contraente']['Citta2']),//Città
                    array(135.13, 120.4, $pageOne['Contraente']['Provincia3']),//Provincia
                    array(59.44, 127, $pageOne['Contraente']['Telefonofisso2']),//Ulteriori recapiti //Telefono fi sso
                    array(103.12, 127, $pageOne['Contraente']['Telefonoufficio2']),//Telefono u cio
                    array(146.3, 127, $pageOne['Contraente']['Cellulare2']),//Cellulare
                    array(60.45, 133.1, $pageOne['Contraente']['email2']),//E-mail
                    array(58.42, 146.05, $pageOne['Assicurato']['Contraente3']),//Assicurato //Contraente
                    array(95.25, 146.05, $pageOne['Assicurato']['Personadiversadal']),//Persona diversa dal Contraente (si prega specifi care di seguito)
                    array(58.67, 151.89, $pageOne['Assicurato']['Sig']),//Cognome, nome //Sig.
                    array(65.53, 151.89, $pageOne['Assicurato']['Sigra']),//Sig.ra
                    array(81.53, 151.89, $pageOne['Assicurato']['Cognome']),//Cognome
                    array(134.87, 151.89, $pageOne['Assicurato']['Nome']),//Nome
                    array(59.69, 158.24, $pageOne['Assicurato']['Indirizzo']),//Residenza //Indirizzo
                    array(174.75, 158.24, $pageOne['Assicurato']['Numero']),//Numero
                    array(59.18, 164.34, $pageOne['Assicurato']['CAP']),//CAP
                    array(81.28, 164.34, $pageOne['Assicurato']['Citta']),//Città
                    array(134.87, 164.34, $pageOne['Assicurato']['Provincia']),//Provincia
                    array(59.44, 170.94, $pageOne['Assicurato']['Datadinascita']),//Data e luogo di nascita //Data di nascita
                    array(80.52, 170.94, $pageOne['Assicurato']['Luogodinascita']),//Luogo di nascita
                    array(134.62, 170.94, $pageOne['Assicurato']['Provincia3']),//Provincia
                    array(156.21, 170.94, $pageOne['Assicurato']['Statodinascita']),//Stato di nascita
                    
                    array(134.62, 177.29, $pageOne['Assicurato']['Professione4']),//Professione
                    array(58.93, 183.64, $pageOne['Assicurato']['Codicefiscale']),//Codice fi scale/ Partita IVA //Codice fi scale
                    array(59.18, 189.74, $pageOne['Assicurato']['Telefonofisso4']),//Recapiti //Telefono fi sso
                    array(102.62, 189.74, $pageOne['Assicurato']['Telefonoufficio4']),//Telefono u cio
                    array(145.8, 189.74, $pageOne['Assicurato']['Cellulare4']),//Cellulare
                    array(58.93, 196.34, $pageOne['Assicurato']['email5']),//E-mail
                    
                    array(58.42, 214.38, $pageOne['Assicurato2']['Sig']),//Cognome, nome / Ragione Sociale //Sig.
                    array(65.53, 214.38, $pageOne['Assicurato2']['Sigra']),//Sig.ra
                    array(72.14, 214.38, $pageOne['Assicurato2']['Soc']),//Soc.
                    array(80.52, 214.38, $pageOne['Assicurato2']['Cognome']),//Cognome / Ragione Sociale
                    array(134.11, 214.38, $pageOne['Assicurato2']['Nome']),//Nome
                    array(58.67, 220.47, $pageOne['Assicurato2']['Datadinascita']),// Data e luogo di nascita //Data di nascita
                    array(80.26, 220.47, $pageOne['Assicurato2']['Luogodinascita']),//Luogo di nascita
                    array(134.11, 220.47, $pageOne['Assicurato2']['Provincia']),//Provincia
                    array(155.96, 220.47, $pageOne['Assicurato2']['Statodinascita']),//Stato di nascita
                    array(58.67, 226.82, $pageOne['Assicurato2']['Percentuale']),//Percentuale / Relazione con il Contraente //Percentuale
                    array(80.77, 226.82, $pageOne['Assicurato2']['Relazione']),//Relazione con il Contraente
                    array(58.67, 233.43, $pageOne['Assicurato2']['Codicefiscale']),//Codice fi scale / Partita IVA //Codice fi scale
                    array(123.44, 233.43, $pageOne['Assicurato2']['PartitaIVA']),//Partita IVA
                    array(58.67, 239.52, $pageOne['Assicurato2']['email']),//E-mail
                    array(58.67, 246.63, $pageOne['Assicurato2']['IlBeneficiario']),//Benefi ciario con disabilità grave (come defi nito dall’art. 3, comma 3, della legge n.104/1992) Referente terzo //Benefi ciario in caso di morte è persona con disabilità grave
                    array(58.67, 257.56, $pageOne['Assicurato2']['Sig2']),//Sig.
                    array(65.53, 257.56, $pageOne['Assicurato2']['Sigra2']),//Sig.ra
                    array(80.52, 257.56, $pageOne['Assicurato2']['Cognome2']),//Cognome
                    array(134.11, 257.56, $pageOne['Assicurato2']['Nome2']),//Nome
                    array(59.18, 263.91, $pageOne['Assicurato2']['Datadinascita2']),//Data di nascita
                    array(80.26, 263.91, $pageOne['Assicurato2']['Luogodinascita2']),//Luogo di nascita
                    array(134.11, 263.91, $pageOne['Assicurato2']['Telefono2']),//Telefono
                    array(58.42, 278, $pageOne['Assicurato2']['Comunicazioni2']),//Comunicazioni al benefi ciario
                );

                $radiobuttons = array(
                    array(58.67, 208.28, $pageOne['Assicurato2']['Altri']),//BENEFICIARIO IN CASO DI MORTE //Benefi ciario in caso di morte //Altri (specifi care nello spazio a seguire)
                    array(112.78, 208.28, $pageOne['Assicurato2']['Eredi']),//Eredi testamentari, in mancanza eredi legittimi dell'Assicurato
                );
                if($pageOne['Contraente']['Territorialita'] == 'Italia'){
                    $radiobuttons[] = array(58.67, 101.85, ">"); //Territorialità fi scale di appartenenza //Italia
                }else{
                    $radiobuttons[] = array(71.88, 101.85, ">"); //USA
                }
                if($pageOne['Assicurato']['Nazionalita2'] == 'Italiana'){
                    $radiobuttons[] = array(58.67, 177.29, ">"); //Nazionalità / Professione //Italiana
                }else{
                    $radiobuttons[] = array(80.52, 177.29, ">"); //Altra nazionalità
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }

                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }

            } else if($pageNo == 2) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(5.5);
                $current_location = self::get_client_location();
                $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(144.78, 3.05, ""), //Proposta Numero
                    array(58.42, 65.53, $pageTwo['Beneficiarioincasodivita']['Contraente']), //Benefi ciario in caso di vita //Contraente
                    array(101.35, 65.53, $pageTwo['Beneficiarioincasodivita']['Assicurato']), //Assicurato
                    array(133.6, 65.53, $pageTwo['Beneficiarioincasodivita']['Altri']), //
                    array(58.17, 71.12, $pageTwo['Beneficiarioincasodivita']['Sig']), //Sig.
                    array(65.02, 71.12, $pageTwo['Beneficiarioincasodivita']['Sigra']), //Sig.ra
                    array(71.63, 71.12, $pageTwo['Beneficiarioincasodivita']['Soc']), //Soc.
                    array(79.76, 71.12, $pageTwo['Beneficiarioincasodivita']['Cognome']), //Cognome / Ragione Sociale
                    array(133.6, 71.12, $pageTwo['Beneficiarioincasodivita']['Nome']), //Nome
                    array(58.17, 78.49, $pageTwo['Beneficiarioincasodivita']['Datadinascita']), //Data e luogo di nascita //Data di nascita
                    array(79.76, 78.49, $pageTwo['Beneficiarioincasodivita']['Luogodinascita']), //Luogo di nascita
                    array(133.86, 78.49, $pageTwo['Beneficiarioincasodivita']['Provincia']), //Provincia
                    array(155.45, 78.49, $pageTwo['Beneficiarioincasodivita']['Statodinascita']), //Stato di nascita
                    array(58.17, 86.11,  $pageTwo['Beneficiarioincasodivita']['Percentuale']), //Percentuale /Relazione con il Contraente //Percentuale
                    array(80.01, 86.11, $pageTwo['Beneficiarioincasodivita']['Relazione']), //Relazione con il Contraente
                    array(58.17, 93.73, $pageTwo['Beneficiarioincasodivita']['Codicefiscale']), //Codice fi scale / Partita IVA //Codice fi scale
                    array(123.19, 93.73, $pageTwo['Beneficiarioincasodivita']['PartitaIVA']), //Partita IVA
                    array(58.17, 100.84, $pageTwo['Beneficiarioincasodivita']['email1']), //E-mail
                    array(58.17, 108.2, $pageTwo['Beneficiarioincasodivita']['Richiestadiescludere']), //Comunicazioni al benefi ciario //Richiesta di escludere l’invio di comunicazioni al benefi …
                    array(58.42, 121.16, $pageTwo['Identificazionedel']['Cartadidentita']), //Identifi cazione Contraente /Legale rappresentante //Carta d’identità
                    array(90.68, 121.16, $pageTwo['Identificazionedel']['Patente']), //Patente
                    array(112.27, 121.16, $pageTwo['Identificazionedel']['Passaporto']), //Passaporto
                    array(133.86, 121.16, $pageTwo['Identificazionedel']['Relazioneconil']), //Numero del documento
                    array(133.6, 128.27, $pageTwo['Identificazionedel']['Codicefiscaledel']), //Codice fi scale del legale rappresentante
                    array(58.42, 135.64, $pageTwo['Identificazionedel']['Datadiemissione']), //Data di emissione
                    array(79.76, 135.64, $pageTwo['Identificazionedel']['Datadiscadenza']), //Data di scadenza
                    array(101.35, 135.64, $pageTwo['Identificazionedel']['Autoritaemittente']), //Autorità emittente
                    array(133.86, 135.64, $pageTwo['Identificazionedel']['Luogodiemissione']), //Luogo di emissione
                    array(133.6, 143, $pageTwo['Identificazionedel']['Si']), //Titolare e ettivo //Sì
                    array(147.57, 143, $pageTwo['Identificazionedel']['No']), //No
                    array(58.42, 153.16, $pageTwo['Identificazionedel']['NomeCognome']), //Sottoscrizione dell’intermediario //Nome, Cognome dell’intermediario
                    // array(127.25, 153.16, "32"), //Firma leggibile dell’intermediario
                    array(58.42, 173.48, $pageTwo['CapacitaDiRisparmio']['Finoa600']), //Capacità di risparmio annua //Fino a 600,– €
                    array(101.35, 173.48, $pageTwo['CapacitaDiRisparmio']['Tra600e5000']), //Tra 600,– € e 5.000,– €
                    array(144.53, 173.48, $pageTwo['CapacitaDiRisparmio']['Oltre5000']), //Oltre 5.000,– €
                    array(58.17, 179.32, $pageTwo['CapacitaDiRisparmio']['Finoa20000']), //Reddito annuo //Fino a 20.000,– €
                    array(101.35, 179.32, $pageTwo['CapacitaDiRisparmio']['Tra20000e35000']), //Tra 20.000,– € e 35.000,– €
                    array(144.53, 179.32, $pageTwo['CapacitaDiRisparmio']['Tra35000e50000']), //Tra 35.000,– € e 50.000,– €
                    array(58.17, 184.91, $pageTwo['CapacitaDiRisparmio']['Tra50000e65000']), //Tra 50.000,– € e 65.000,– €
                    array(101.35, 184.91, $pageTwo['CapacitaDiRisparmio']['Oltre65000']), //Oltre 65.000,– €
                    array(57.91, 190.75, $pageTwo['CapacitaDiRisparmio']['Redditofisso']), //Tipologia di reddito annuo //Reddito fi sso
                    array(87.12, 190.75, $pageTwo['CapacitaDiRisparmio']['Redditovariabilenoncerto']), //Reddito variabile non certo
                    array(58.17, 196.6, $pageTwo['CapacitaDiRisparmio']['Nessuno']), //Impegni fi nanziari già assunti //Nessuno
                    array(87.12, 196.6, $pageTwo['CapacitaDiRisparmio']['Finoa1000']), //Fino a 1.000,– €
                    array(116.08, 196.6, $pageTwo['CapacitaDiRisparmio']['Tra1000e5000']), //Tra 1.000,– € e 5.000,– €
                    array(153.92, 196.6,  $pageTwo['CapacitaDiRisparmio']['Superiorea5000']), //Superiore a 5.000,– €
                    array(58.17, 202.44, $pageTwo['CapacitaDiRisparmio']['Numero']), //Numero componenti del nucleo familiare //Numero
                    array(87.38, 202.44, $pageTwo['CapacitaDiRisparmio']['Dicuiacarico']), //Di cui a carico
                    array(57.91, 213.87, $pageTwo['DecorrenzaEDurata']['DatadiDecorrenza']), //Data di Decorrenza e Durata del Contratto //Data di Decorrenza
                    array(106.93, 213.87, $pageTwo['DecorrenzaEDurata']['DuratadelContratto']), //Durata del Contratto /Anni
                    array(62.48, 226.06, $pageTwo['Premio']['Premioannuo']), //Premio annuo
                    array(81.53, 225.55, $pageTwo['Premio']['money']), //Premio annuo price
                    //array(113.28, 227.84, $pageTwo['Premio']['Opzionediincremento']), //OPZIONE DI INCREMENTO AUTOMATICO DEL PREMIO //
                    array(152.4, 234.7, $pageTwo['Premio']['ImportoRatadiPremio']), //Importo Rata di Premio
                    array(173.99, 234.7, $pageTwo['Premio']['money2']), //€
                    array(154.69, 240.03, $pageTwo['Premio']['PrimaRata']), //Prima Rata /importo del primo Premio //Trimestrale
                    array(174.24, 240.54, $pageTwo['Premio']['money3']), //Semestrale
                    // array(122.94, 241.55, "62"), //Annuale
                    array(152.15, 241.55, $pageTwo['ModalitaDiPagamento']['Primopremio']), //Prima Rata / Primo Premio\
                    array(173.74, 241.55, ""), //€
                );
                $radiobuttons = array(
                    array(58.17, 260.1, $pageTwo['ModalitaDiPagamento']['Primopremio']), //Primo premio / Premi successivi(barrare la modalità scelta) //Primo premio 1
                    array(69.6, 260.1, $pageTwo['ModalitaDiPagamento']['Premisuccessivi']), //Premi successivi 1
                    array(58.42, 265.94, $pageTwo['ModalitaDiPagamento']['Primopremio2']), //Primo premio 2
                    array(69.6, 265.94, $pageTwo['ModalitaDiPagamento']['Premisuccessivi2']), //Premi successivi 2
                );
                if($pageTwo['Premio']['PackageEmi'] || $pageTwo['Premio']['PackageEmi1']){
                    $radiobuttons[] = array(58.17, 234.7,">");
                    $radiobuttons[] = array(79.25, 240.03,">");
                }else{
                    $radiobuttons[] = array(58.17, 234.7," ");
                    $radiobuttons[] = array(79.25, 240.03," ");
                }
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                // $pdf->SetFont('ZapfDingbats','', 10);
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } 
            else if ($pageNo == 3) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(5.5);
                $current_location = self::get_client_location();
                $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(144.27, 2.79, $pageThree['Autorizzazioneal']['numerodipolizza']), //Proposta Numero
                    array(58.17, 87.38, $pageThree['Autorizzazioneal']['Pagamentoricorrente']), //IBAN //IBAN
                    array(58.17, 98.3, $pageThree['Autorizzazioneal']['Sig']), //Intestatario del conto //Sig.
                    array(65.02, 98.3, $pageThree['Autorizzazioneal']['Sigra']), //Sig.ra
                    array(71.63, 98.3, $pageThree['Autorizzazioneal']['Soc']), //Soc.
                    array(80.01, 98.3, $pageThree['Autorizzazioneal']['Cognome']), //Cognome / Ragione Sociale
                    array(134.11, 98.3, $pageThree['Autorizzazioneal']['Nome']), //Nome
                    array(58.42, 104.9, $pageThree['Autorizzazioneal']['Indirizzo']), //Indirizzo
                    array(173.99, 104.9, $pageThree['Autorizzazioneal']['Numero']), //Numero
                    array(58.17, 111.76, $pageThree['Autorizzazioneal']['CAP']), //CAP
                    array(79.76, 111.76, $pageThree['Autorizzazioneal']['Citta']), //Città
                    array(133.86, 111.76, $pageThree['Autorizzazioneal']['Provincia']), //Provincia
                    array(58.42, 118.62, $pageThree['Autorizzazioneal']['Codicefiscale']), //Codice fi scale* / Partita IVA //Codice fi scale
                    array(123.44, 118.62, $pageThree['Autorizzazioneal']['PartitaIVA']), //Partita IVA
                    array(58.42, 131.57, "16"), //Sottoscrizione dell’intestatario del conto //Data
                    array(80.01, 131.57, $current_location['country']), //Luogo
                    // array(127.51, 131.57, "18"), //Firma dell’intestatario del conto o del procuratore
                    array(58.42, 148.08, $pageThree['Identificazionedel']['Contraente']), //Pagatore //Contraente
                    array(101.6, 148.08, $pageThree['Identificazionedel']['Persona']), //Persona diversa dal Contraente
                    array(58.17, 154.18, $pageThree['Identificazionedel']['Sig']), //Sig.
                    array(65.02, 154.18, $pageThree['Identificazionedel']['Sigra']), //Sig.ra
                    array(71.63, 154.18, $pageThree['Identificazionedel']['Soc']), //Soc.
                    array(80.01, 154.18, $pageThree['Identificazionedel']['Cognome']), //Cognome / Ragione Sociale
                    array(133.86, 154.18, $pageThree['Identificazionedel']['Nome']), //Nome
                    array(58.42, 161.04, $pageThree['Identificazionedel']['Indirizzo']), //Residenza / Sede legale //Indirizzo
                    array(174.5, 161.29, $pageThree['Identificazionedel']['Numero']), //Numero
                    array(58.17, 168.15, $pageThree['Identificazionedel']['CAP']), //CAP
                    array(79.76, 168.15, $pageThree['Identificazionedel']['Citta']), //Città
                    array(134.11, 168.15, $pageThree['Identificazionedel']['Provincia']), //Provincia
                    array(58.42, 174.75, $pageThree['Identificazionedel']['Datadinascita']), //Data e luogo di nascita //Data di nascita
                    array(80.26, 174.75, $pageThree['Identificazionedel']['Luogodinascita']), //Luogo di nascita
                    array(134.62, 174.75, $pageThree['Identificazionedel']['Provincia2']), //Provincia
                    array(155.7, 174.75, $pageThree['Identificazionedel']['Statodinascita']), //Stato di nascita
                    array(58.42, 181.86, $pageThree['Identificazionedel']['Codicefiscale']), //Codice fi scale / Partita IVA //Codice fi scale
                    array(122.94, 181.86, $pageThree['Identificazionedel']['PartitaIVA']), //Partita IVA
                    array(58.17, 188.47, $pageThree['Identificazionedel']['Relazioneconil']), //Relazione con il Contraente
                    array(123.19, 188.47, $pageThree['Identificazionedel']['Professione']), //Professione
                    array(156.21, 188.47, $pageThree['Identificazionedel']['Settoreeconomico']), //Settore economico
                    array(58.67, 195.58, $pageThree['Identificazionedel']['Cartadidentita']), //Identifi cazione del pagatore //Carta d’identità
                    array(88.14, 195.58, $pageThree['Identificazionedel']['Patente']), //Patente
                    array(111, 195.58, $pageThree['Identificazionedel']['Passaporto']), //Passaporto
                    array(133.86, 195.58, $pageThree['Identificazionedel']['Numerodeldocumento']), //Numero del documento
                    array(58.17, 202.18, $pageThree['Identificazionedel']['Datadiemissione']), //Data di emissione
                    array(80.01, 202.18, $pageThree['Identificazionedel']['Datadiscadenza']), //Data di scadenza
                    array(101.6, 202.18, $pageThree['Identificazionedel']['Autoritaemittente']), //Autorità emittente
                    array(134.11, 202.18, $pageThree['Identificazionedel']['Luogodiemissione']), //Luogo di emissione
                    array(58.42, 210.06, $pageThree['Identificazionedel']['Ilversamento']), //Dichiarazioni del Pagatore //versamento è e ettuato in conto proprio
                    array(122.68, 210.06, $pageThree['Identificazionedel']['Ilversamento2']), //versamento è e ettuato per conto di terzi
                    array(58.17, 221.49, $pageThree['Identificazionedel']['Sig2']), //Nome ed indirizzo della persona per conto della quale è e ettuato il versamento //Sig.
                    array(64.77, 221.49, $pageThree['Identificazionedel']['Sigra2']), //Sig.ra
                    array(71.63, 221.49, $pageThree['Identificazionedel']['Soc2']), //Soc.
                    array(80.01, 221.49, $pageThree['Identificazionedel']['Cognome2']), //Cognome / Ragione Sociale
                    array(133.86, 221.49, $pageThree['Identificazionedel']['Nome2']), //Nome
                    array(58.17, 227.84, $pageThree['Identificazionedel']['Indirizzo2']), //Indirizzo
                    array(174.5, 227.84, $pageThree['Identificazionedel']['Numero2']), //Numero
                    array(58.67, 234.95, $pageThree['Identificazionedel']['CAP2']), //CAP
                    array(80.01, 234.95, $pageThree['Identificazionedel']['Citta2']), //Città
                    array(134.37, 234.95, $pageThree['Identificazionedel']['Provincia3']), //Provincia
                    array(58.17, 242.06, $pageThree['Identificazionedel']['Datadinascita2']), //Data e luogo di nascita //Data di nascita
                    array(80.01, 242.06, $pageThree['Identificazionedel']['Luogodinascita2']), //Luogo di nascita
                    array(134.37, 242.06, $pageThree['Identificazionedel']['Provincia4']), //Provincia
                    array(156.21, 242.06, $pageThree['Identificazionedel']['Statodinascita2']), //Stato di nascita
                    array(58.42, 248.67, $pageThree['Identificazionedel']['Codicefiscale2']), //Codice fi scale
                    array(123.19, 248.67, $pageThree['Identificazionedel']['PartitaIVA2']), //Partita IVA
                    array(57.91, 255.78, $pageThree['Identificazionedel']['Redditoprofessionale']), //premio versato proviene da //Reddito professionale
                    array(101.35, 255.78, $pageThree['Identificazionedel']['Risparmio']), //Risparmio
                    array(133.6, 255.78, $pageThree['Identificazionedel']['Eredita']), //Eredità
                    array(58.17, 261.37, $pageThree['Identificazionedel']['Altro']), //Altro
                    array(80.26, 261.37, $pageThree['Identificazionedel']['Specificarele']), //Specifi care le altre origini del versamento
                    array(58.42, 268.22, $date), //Sottoscrizione del Pagatore //Data
                    array(80.01, 268.22, $current_location['country']), //Luogo
                    // array(127.25, 268.22, "73"), //Firma del pagatore
                    
                    array(58.67, 275.08, $date), //Sottoscrizione dell’intermediario //Data
                    array(79.76, 275.08, $current_location['country']), //Luogo
                    // array(127, 275.08, "76"), //Firma dell’intermediario
                );
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
            } else if ($pageNo == 4){
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(5.5);
                $current_location = self::get_client_location();
                $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    // array(144.78, 2.54, "1"), //Proposta Numero
                    // array(58.42, 50.04, "2"), //Ha o ha avuto cariche pubbliche importanti in Italia o in qualsiasi altra nazione? //Sì
                    // array(72.39, 50.04, "3"), //No
                    // array(122.94, 50.04, "4"), //Se sì, descriva la tipologia di lavoro e specifi chi la data di inizio:
                    // array(58.17, 59.94, "5"), //Ci sono familiari a lei vicini con cariche pubbliche importanti? //Sì
                    // array(72.14, 59.94, "6"), //No
                    // array(123.19, 59.94, "7"), //Se sì, descriva la tipologia di lavoro e specifi chi la data di inizio:
                    // array(57.91, 72.14, "8"), //Attualmente lavora o collabora a stretto contatto con persone con cariche pubbliche importanti? //Sì
                    // array(72.14, 72.14, "9"), //No
                    // array(122.94, 72.14, "10"), //Se sì, descriva la tipologia di lavoro e specifi chi la data di inizio:
                    array(14.99, 151.13, date('Y-m-d')), //CONSEGNA DELLA DOCUMENTAZIONE E ACCETTAZIONE //Data
                    array(36.83, 151.13, $current_location['country']), // Luogo
                    // array(126.49, 151.13, "13"), //Firma leggibile del Contraente
                    array(14.99, 191.01, date('Y-m-d')), //DICHIARAZIONI DEL CONTRAENTE //Data
                    array(36.58, 191.01, $current_location['country']), //Luogo
                    // array(127.25, 191.01, "16"), //Firma leggibile del Contraente
                    array(15.24, 203.71, date('Y-m-d')), //CONSEGNA DEI DOCUMENTI RELATIVI ALL’INTERMEDIARIO //Data
                    array(36.58, 203.71, $current_location['country']), //Luogo
                    // array(128.27, 203.71, "19"), //Firma leggibile del Contraente
                    array(14.99, 231.39, date('Y-m-d')), //DICHIARAZIONI DELL’ASSICURATO SE DIVERSO DAL CONTRAENTE //Data
                    array(36.58, 231.39, $current_location['country']), //Luogo
                    array(68.83, 231.39,date('Y-m-d')), //Specifi care la relazione col Contraente
                    // array(127.51, 231.39, "23"), //Firma dell’Assicurato
                    // array(14.73, 260.86, "24"), //DICHIARAZIONI DELL’INTERMEDIARIO //addebito diretto SEPA
                    // array(58.17, 260.86, "25"), //CBILL
                    array(14.99, 265.94, date('Y-m-d')), //Data
                    array(36.83, 265.94, $current_location['country']), //Luogo
                    // array(80.52, 265.94, "28"), //Cognome e nome dell’intermediario
                    // array(126.75, 265.94, "29"), //Firma leggibile dell’intermediario
                );
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
            }
        }
        //Output the new PDF
        $file_name = uniqid() . 'form-2';
        $pdf->Output('testing/' . $file_name . '.pdf','F');
        //Get Full Path of Generated PDF File
        $file_full_path = public_path('testing/' . $file_name . '.pdf');
        return $file_full_path; 
    }

    // fill data in form One
    public static function generateSignPDFFormOne($sale)
    {

        $pageOne = $sale['personalInfo']['pageOne'];
        $pageTwo = $sale['personalInfo']['pageTwo'];
        $pageThree = $sale['personalInfo']['pageThree'];
        $date = date('Y-m-d');
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile(self::template_document_file_one);
        $pdf->SetAutoPageBreak(TRUE, 0);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);

            if($pageNo == 1) {
                //Output Name
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                $cordinates = array(
                    array(44.96, 27.94, $pageOne['CodiceIntermediario']), //Codice Intermediario
                    array(94.74, 27.94, $pageOne['SottoCodice']), //Sotto-codice
                    array(173.48, 30.73, $date), //Data
                    array(37.59, 70.1, $pageOne['sectionA']['Cognomeenome1']), //SEZIONE A - DATI IDENTIFICATIVI DEL CONTRAENTE /ADERENTE //Cognome e nome
                    array(32.51, 75.44, $pageOne['sectionA']['Datadinascita1']), //Data di nascita
                    array(72.39, 75.44, $pageOne['sectionA']['Luogodinascita1']), //Luogo di nascita
                    array(153.16, 75.44, $pageOne['sectionA']['Nazionalità1']), //Nazionalità
                    array(25.4, 81.53, $pageOne['sectionA']['formCodFisc1']), //Cod.Fisc.
                    array(114.55, 81.28, $pageOne['sectionA']['Tipodocdiidentita1']), //Tipo doc. di identità
                    array(16.76, 86.87, $pageOne['sectionA']['N1']), //N.
                    array(51.05, 86.87, $pageOne['sectionA']['Rilasciatoil1']), //Rilasciato il
                    array(73.15, 86.87, $pageOne['sectionA']['da1']), //da
                    array(37.59, 92.46, $pageOne['sectionA']['Localitadirilascio1']), //Località di rilascio
                    array(161.8, 92.2, $pageOne['sectionA']['Datascadenzadocidentita1']), //Data scadenza doc. identità
                    array(42.16, 98.3, $pageOne['sectionA']['Indirizzodiresidenza1']), //Indirizzo di residenza
                    array(133.35, 98.3, $pageOne['sectionA']['CAP1']), //CAP
                    array(157.48, 98.3, $pageOne['sectionA']['Prov1']), //Prov.
                    array(175.51, 98.3, $pageOne['sectionA']['Stato21']), //Stato2
                    array(26.16, 103.63, $pageOne['sectionA']['Telefono1']), //Telefono
                    array(117.09, 103.63, $pageOne['sectionA']['Mail1']), //Mail
                    array(65.02, 108.97, $pageOne['sectionA']['inqualitadi1']), //SI1, in qualità di // text
                    array(81.03, 115.32, $pageOne['sectionA']['inquanto1']), //SI1,in quanto // text
                    array(36.07, 135.89, $pageOne['sectionB']['Cognomeenome1']), //SEZIONE B – ALTRI SOGGETTI //Cognome e nome
                    array(141.73, 135.89, $pageOne['sectionB']['CodFisc1']), //Cod.Fisc
                    array(32, 142.24,  $pageOne['sectionB']['Datadinascita1']), //Data di nascita
                    array(85.85, 142.24, $pageOne['sectionB']['Luogodinascita1']), //Luogo di nascita
                    // array(127.51, 148.59, '27'), //Paesi Terzi1, quale //text
                    // array(63.5, 165.35, '28'), //SI1, in qualità di //text
                    array(36.58, 175.01, $pageOne['sectionB']['Cognomeenome2']), //Cognome e nome
                    array(141.48, 175.51, $pageOne['sectionB']['CodFisc2']), //Cod.Fisc.
                    array(32.77, 180.85, $pageOne['sectionB']['Datadinascita2']), //Data di nascita
                    array(86.36, 181.36, $pageOne['sectionB']['Luogodinascita2']), //Luogo di nascita
                    // array(125.98, 187.45, '33'), //Paesi Terzi1, quale // text
                    // array(64.26, 204.22, '34'), //SI1, in qualità di // text
                    array(35.31, 213.87, $pageOne['sectionB']['Cognomeenome3']), //Cognome e nome
                    array(141.73, 213.87, $pageOne['sectionB']['CodFisc3']), //Cod.Fisc.
                    array(32.77, 219.71, $pageOne['sectionB']['Datadinascita3']), //Data di nascita
                    array(86.11, 219.71, $pageOne['sectionB']['Luogodinascita3']), //Luogo di nascita
                    // array(125.98, 225.81, '39'), //Paesi Terzi1, quale // text
                    // array(65.28, 242.82, '40'), //SI1, in qualità di //text
                );

                //radio button cordinates
                $radiobuttons = array(
                    array(46.74, 148.59, $pageOne['sectionB']['Italia1']), //Paese di Residenza: //Italia
                    array(71.88, 148.59, $pageOne['sectionB']['UE1']), //UE
                    array(96.77, 148.59, $pageOne['sectionB']['PaesiTerzi1quale1']), //Paesi Terzi1, quale
                    array(11.94, 154.69, $pageOne['sectionB']['appartiene1']), //appartiene al nucleo familiare dell’Assicurato
                    array(88.14, 154.69, $pageOne['sectionB']['harapporti1']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.94, 160.02, $pageOne['sectionB']['noneri1']), //non è riconducibile né all’ambito familiare né professionale1
                    array(45.97, 187.45, $pageOne['sectionB']['Italia2']), //Paese di Residenza: //Italia
                    array(71.37, 187.45, $pageOne['sectionB']['UE2']), //UE
                    array(96.77, 187.45, $pageOne['sectionB']['PaesiTerzi1quale2']), //Paesi Terzi1, quale
                    array(11.68, 193.04, $pageOne['sectionB']['appartiene2']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 193.04, $pageOne['sectionB']['harapporti2']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 198.63, $pageOne['sectionB']['noneri2']), //non è riconducibile né all’ambito familiare né professionale1
                    array(46.23, 225.81, $pageOne['sectionB']['Italia3']), //Paese di Residenza: //Italia
                    array(71.12, 225.81, $pageOne['sectionB']['UE3']), //UE
                    array(96.52, 225.81, $pageOne['sectionB']['PaesiTerzi1quale3']), //Paesi Terzi1, quale
                    array(11.68, 231.65, $pageOne['sectionB']['appartiene3']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 231.65, $pageOne['sectionB']['harapporti3']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 236.98, $pageOne['sectionB']['noneri3']), //non è riconducibile né all’ambito familiare né professionale1
                );
                

                if($pageOne['PresenzafisicadelCliente'] == 'si'){
                    //Presenza fisica del Cliente //SI
                    $radiobuttons[] = array(10.75, 47.5, '>');
                }else{
                    //NO
                    $radiobuttons[] = array(31.50, 47.5, '>');
                     //Se, NO //Firma Digitale
                    $radiobuttons[] = array(44.45, 53.34, $pageOne['FirmaDigitale']);
                    //Collegamento Audio/Video1)
                    $radiobuttons[] = array(71,53.34,$pageOne['CollegamentoAudio']);
                }
                if($pageOne['sectionA']['Sesso1'] == 'm'){
                    $radiobuttons[] = array(76, 81.53, '>'); //Sesso: //M
                }else{
                    $radiobuttons[] = array(82.25, 81.53, '>'); //F
                }
                if($pageOne['sectionA']['PEP31'] == 'no'){
                    $radiobuttons[] = array(22.1, 108.97, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(38, 108.97, '>'); //SI1, in qualità di
                }
                if($pageOne['sectionA']['IncarichiPubblici4'] == 'no'){
                    $radiobuttons[] = array(41.91, 115.32, '>'); //Incarichi Pubblici4 //NO
                }else{
                    $radiobuttons[] = array(58.67, 115.32, '>'); //SI1,in quanto
                }

                if($pageOne['sectionB']['PEP32'] == 'no'){
                    $radiobuttons[] = array(20.83, 165.35, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 165.35, '>'); //SI1, in qualità di
                }


                if($pageOne['sectionB']['PEP33'] == 'no'){
                    $radiobuttons[] = array(20.83, 204.22, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 204.22, '>'); //SI1, in qualità di
                }

                if($pageOne['sectionB']['PEP34'] == 'no'){
                    $radiobuttons[] = array(20.83, 242.82, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 242.82, '>'); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach($radiobuttons as $radiobutton){
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 2) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(37.08, 38.35, $pageTwo['sectionB']['Cognomeenome4']), //Cognome e nome
                    array(140.97, 38.35, $pageTwo['sectionB']['CodFisc4']), //Cod.Fisc.
                    array(32.26, 43.69, $pageTwo['sectionB']['Datadinascita4']), //Data di nascita
                    array(85.85, 43.69, $pageTwo['sectionB']['Luogodinascita4']), //Luogo di nascita
                    // array(66.29, 104.9, "5"), //SI1, in qualità di //text
                    array(36.83, 76.45, $pageTwo['sectionB']['Cognomeenome5']), //Beneficiario : //Cognome e nome
                    array(141.99, 76.45, $pageTwo['sectionB']['CodFisc5']), //Cod.Fisc.
                    array(32.77, 83.06, $pageTwo['sectionB']['Datadinascita5']), //Data di nascita
                    array(85.85, 83.06, $pageTwo['sectionB']['Luogodinascita5']), //Luogo di nascita
                    // array(128.78, 89.41, "10"), //Paesi Terzi1, quale // text
                    array(37.59, 114.81, $pageTwo['sectionB']['Cognomeenome6']), //Il Pagatore (se diverso dal contraente/aderente): //Cognome e nome
                    array(141.22, 114.81, $pageTwo['sectionB']['CodFisc6']), //Cod.Fisc.
                    array(32.51, 119.89, $pageTwo['sectionB']['Datadinascita6']), //Data di nascita
                    array(85.34, 119.89, $pageTwo['sectionB']['Luogodinascita6']), //Luogo di nascita
                    // array(125.98,126.49, "14"), //Paesi Terzi1, quale // text
                    // array(72.64, 141.73, "15"), //In ogni caso, specificare il rapporto tra le parti
                    // array(65.79, 146.81, "16"), //SI1, in qualità di // text
                    // array(133.35, 166.37, "17"), //Stato Estero1, specificare quale // text
                    array(14.73, 177.29, $pageTwo['sectionC']['Cognomeenome']), //(Cognome e nome)
                    array(74.93, 177.29, $pageTwo['sectionC']['CodiceFiscale']), //(Codice Fiscale)
                    array(136.4, 177.29, $pageTwo['sectionC']['Residenza']), //(Residenza)
                    array(14.22, 213.87, $pageTwo['sectionC']['Luogoedata']), //Luogo e data
                    // array(117.6, 213.87, "22"), //Firma del Contraente/aderente
                    
                );
                $radiobuttons = array(
                    array(45.47, 49.78, $pageTwo['sectionB']['Italia4']), //Paese di Residenza: //Italia
                    array(70.87, 49.78, $pageTwo['sectionB']['UE4']), //UE
                    array(96.01, 49.78, $pageTwo['sectionB']['PaesiTerzi1quale4']), //Paesi Terzi1, quale
                    // array(127.76, 49.78, "X"), //Paesi Terzi1, quale // text
                    array(11.18, 56.39, $pageTwo['sectionB']['appartiene4']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 56.39, $pageTwo['sectionB']['harapporti4']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 61.21, $pageTwo['sectionB']['noneri4']), //non è riconducibile né all’ambito familiare né professionale1
                    
                    array(45.97, 89.41, $pageTwo['sectionB']['Italia5']), //Paese di Residenza: //Italia
                    array(70.61, 89.41, $pageTwo['sectionB']['UE5']), //UE
                    array(96.52, 89.41, $pageTwo['sectionB']['PaesiTerzi1quale5']), //Paesi Terzi1, quale
                    array(11.43, 95, $pageTwo['sectionB']['appartiene5']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 95, $pageTwo['sectionB']['harapporti5']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 100.33, $pageTwo['sectionB']['noneri5']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(64.77, 105.41, "X"), //SI1, in qualità di // text
                    array(44.96, 126.49, $pageTwo['sectionB']['Italia6']), //Paese di Residenza: //Italia
                    array(70.61, 126.49, $pageTwo['sectionB']['UE6']), //UE
                    array(95.76, 126.49, $pageTwo['sectionB']['PaesiTerzi1quale6']), //Paesi Terzi1, quale
                    array(10.92, 131.06, $pageTwo['sectionB']['appartiene6']), //appartiene al nucleo familiare dell’Assicurato
                    array(86.61, 131.06, $pageTwo['sectionB']['harapporti6']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(10.67, 137.16, $pageTwo['sectionB']['noneri6']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(73.15, 189.99, "X"), //SI1, in qualità di // text
                );

                if($pageTwo['sectionB']['PEP35'] == 'no'){
                    $radiobuttons[] = array(20.83, 67.50, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 67.50, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP36'] == 'no'){
                    $radiobuttons[] = array(20.83, 105.41, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 105.41, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP37'] == 'no'){
                    $radiobuttons[] = array(20.07, 146.81, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 146.81, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionC']['Istitutodicredito'] == 'Italia'){
                    $radiobuttons[] = array(74.42, 166.37, ">"); //SEZIONE C – ULTERIORI INFORMAZIONI //Istituto di credito di provenienza/destinazione //Italia
                }else{
                    $radiobuttons[] = array(87.12, 166.37, ">"); //Stato Estero1, specificare quale
                }

                if($pageTwo['sectionC']['TitolareEffettivo'] == 'Unico'){
                    $radiobuttons[] = array(57.91, 172.47, ">"); //Titolare Effettivo del Rapporto: //Unico Titolare Effettivo
                }else{
                    $radiobuttons[] = array(119.63, 172.47, ">"); //Titolare Effettivo unitamente a:
                }

                if($pageTwo['sectionC']['PEP38'] == 'no'){
                    $radiobuttons[] = array(23.88, 189.99, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(44.45, 189.99, ">"); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 3) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    // array(99.57, 69.34, "1"), //Altre anomalie comportamentali riscontrate1. Specificare // text
                    // array(160.02, 76.71, "1"), //No1. Specificare il motivo // text
                    array(29.72, 117.09, $pageThree['sectionD']['Cognome']), //Cognome
                    array(109.47, 117.09, $pageThree['sectionD']['Nome']), //Nome
                    array(71.88, 124.21, $pageThree['sectionD']['Codice']), //Codice soggetto incaricato al collocamento
                    array(143.51, 124.21, $pageThree['sectionD']['Numiscrizione']), //Num. iscrizione RUI
                    array(92.71, 130.56, $pageThree['sectionD']['Regione']), //Regione di attività del soggetto incaricato del collocamento
                    array(35.31, 137.92, $pageThree['sectionD']['Luogoedata']), //Luogo e data
                    // array(110.24, 137.92, "8"), //Timbro/Firma
                    // array(35.81, 155.19, "9"), //Validazione percorso di Adeguata Verifica //Intermediario
                    array(126.49, 155.19, $pageThree['sectionD']['TimbroFirma']), //Timbro/Firma
                    // array(84.58, 181.61, "11"), //Spazio riservato alla Compagnia //Tipo verifica sul nominativo:
                    array(33.53, 188.21, $pageThree['sectionD']['WCL']), //WCL
                    array(19.56, 199.64, $pageThree['sectionD']['Altro']), //Altro esito delle verifiche:
                    
                );
                $radiobuttons = array(
                    array(17.78, 49.78, $pageThree['sectionD']['Normale']), //Comportamento tenuto dal cliente all’instaurazione del rapporto continuativo //Normale
                    array(17.78, 54.86, $pageThree['sectionD']['Riluttanza']), //Riluttanza e/o reticenza nel fornire le informazioni richieste1
                    array(17.78, 59.18, $pageThree['sectionD']['Interposizione']), //Interposizione di soggetti terzi senza apparente giustificazione1
                    array(17.78, 64.77, $pageThree['sectionD']['Ilcliente']), //cliente mostra una inusuale familiarità con le norme antiriciclaggio1
                    array(17.78, 69.34, $pageThree['sectionD']['Altreanomalie']), //Altre anomalie comportamentali riscontrate1. Specificare
                );

                if($pageThree['sectionD']['Leinformazioni'] == 'si'){
                    $radiobuttons[] = array(107.19, 76.71, ">"); //Le informazioni ricevute dal cliente, sono da ritenersi attendibili? //Si
                }else{
                    $radiobuttons[] = array(121.92, 76.71, ">"); //No1. Specificare il motivo
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } 
        }
        // Output the new PDF
        $file_name = uniqid().'form-1';
        $pdf->Output('testing/' . $file_name . '.pdf','F');
        // Get Full Path of Generated PDF File
        $file_full_path = public_path('testing/' . $file_name . '.pdf');
        return $file_full_path;
    }

    // fill data in form One
    public static function generateSignPDFFormOne($sale)
    {

        $pageOne = $sale['personalInfo']['pageOne'];
        $pageTwo = $sale['personalInfo']['pageTwo'];
        $pageThree = $sale['personalInfo']['pageThree'];
        $date = date('Y-m-d');
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile(self::template_document_file_one);
        $pdf->SetAutoPageBreak(TRUE, 0);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);

            if($pageNo == 1) {
                //Output Name
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                $cordinates = array(
                    array(44.96, 27.94, $pageOne['CodiceIntermediario']), //Codice Intermediario
                    array(94.74, 27.94, $pageOne['SottoCodice']), //Sotto-codice
                    array(173.48, 30.73, $date), //Data
                    array(37.59, 70.1, $pageOne['sectionA']['Cognomeenome1']), //SEZIONE A - DATI IDENTIFICATIVI DEL CONTRAENTE /ADERENTE //Cognome e nome
                    array(32.51, 75.44, $pageOne['sectionA']['Datadinascita1']), //Data di nascita
                    array(72.39, 75.44, $pageOne['sectionA']['Luogodinascita1']), //Luogo di nascita
                    array(153.16, 75.44, $pageOne['sectionA']['Nazionalità1']), //Nazionalità
                    array(25.4, 81.53, $pageOne['sectionA']['formCodFisc1']), //Cod.Fisc.
                    array(114.55, 81.28, $pageOne['sectionA']['Tipodocdiidentita1']), //Tipo doc. di identità
                    array(16.76, 86.87, $pageOne['sectionA']['N1']), //N.
                    array(51.05, 86.87, $pageOne['sectionA']['Rilasciatoil1']), //Rilasciato il
                    array(73.15, 86.87, $pageOne['sectionA']['da1']), //da
                    array(37.59, 92.46, $pageOne['sectionA']['Localitadirilascio1']), //Località di rilascio
                    array(161.8, 92.2, $pageOne['sectionA']['Datascadenzadocidentita1']), //Data scadenza doc. identità
                    array(42.16, 98.3, $pageOne['sectionA']['Indirizzodiresidenza1']), //Indirizzo di residenza
                    array(133.35, 98.3, $pageOne['sectionA']['CAP1']), //CAP
                    array(157.48, 98.3, $pageOne['sectionA']['Prov1']), //Prov.
                    array(175.51, 98.3, $pageOne['sectionA']['Stato21']), //Stato2
                    array(26.16, 103.63, $pageOne['sectionA']['Telefono1']), //Telefono
                    array(117.09, 103.63, $pageOne['sectionA']['Mail1']), //Mail
                    array(65.02, 108.97, $pageOne['sectionA']['inqualitadi1']), //SI1, in qualità di // text
                    array(81.03, 115.32, $pageOne['sectionA']['inquanto1']), //SI1,in quanto // text
                    array(36.07, 135.89, $pageOne['sectionB']['Cognomeenome1']), //SEZIONE B – ALTRI SOGGETTI //Cognome e nome
                    array(141.73, 135.89, $pageOne['sectionB']['CodFisc1']), //Cod.Fisc
                    array(32, 142.24,  $pageOne['sectionB']['Datadinascita1']), //Data di nascita
                    array(85.85, 142.24, $pageOne['sectionB']['Luogodinascita1']), //Luogo di nascita
                    // array(127.51, 148.59, '27'), //Paesi Terzi1, quale //text
                    // array(63.5, 165.35, '28'), //SI1, in qualità di //text
                    array(36.58, 175.01, $pageOne['sectionB']['Cognomeenome2']), //Cognome e nome
                    array(141.48, 175.51, $pageOne['sectionB']['CodFisc2']), //Cod.Fisc.
                    array(32.77, 180.85, $pageOne['sectionB']['Datadinascita2']), //Data di nascita
                    array(86.36, 181.36, $pageOne['sectionB']['Luogodinascita2']), //Luogo di nascita
                    // array(125.98, 187.45, '33'), //Paesi Terzi1, quale // text
                    // array(64.26, 204.22, '34'), //SI1, in qualità di // text
                    array(35.31, 213.87, $pageOne['sectionB']['Cognomeenome3']), //Cognome e nome
                    array(141.73, 213.87, $pageOne['sectionB']['CodFisc3']), //Cod.Fisc.
                    array(32.77, 219.71, $pageOne['sectionB']['Datadinascita3']), //Data di nascita
                    array(86.11, 219.71, $pageOne['sectionB']['Luogodinascita3']), //Luogo di nascita
                    // array(125.98, 225.81, '39'), //Paesi Terzi1, quale // text
                    // array(65.28, 242.82, '40'), //SI1, in qualità di //text
                );

                //radio button cordinates
                $radiobuttons = array(
                    array(46.74, 148.59, $pageOne['sectionB']['Italia1']), //Paese di Residenza: //Italia
                    array(71.88, 148.59, $pageOne['sectionB']['UE1']), //UE
                    array(96.77, 148.59, $pageOne['sectionB']['PaesiTerzi1quale1']), //Paesi Terzi1, quale
                    array(11.94, 154.69, $pageOne['sectionB']['appartiene1']), //appartiene al nucleo familiare dell’Assicurato
                    array(88.14, 154.69, $pageOne['sectionB']['harapporti1']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.94, 160.02, $pageOne['sectionB']['noneri1']), //non è riconducibile né all’ambito familiare né professionale1
                    array(45.97, 187.45, $pageOne['sectionB']['Italia2']), //Paese di Residenza: //Italia
                    array(71.37, 187.45, $pageOne['sectionB']['UE2']), //UE
                    array(96.77, 187.45, $pageOne['sectionB']['PaesiTerzi1quale2']), //Paesi Terzi1, quale
                    array(11.68, 193.04, $pageOne['sectionB']['appartiene2']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 193.04, $pageOne['sectionB']['harapporti2']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 198.63, $pageOne['sectionB']['noneri2']), //non è riconducibile né all’ambito familiare né professionale1
                    array(46.23, 225.81, $pageOne['sectionB']['Italia3']), //Paese di Residenza: //Italia
                    array(71.12, 225.81, $pageOne['sectionB']['UE3']), //UE
                    array(96.52, 225.81, $pageOne['sectionB']['PaesiTerzi1quale3']), //Paesi Terzi1, quale
                    array(11.68, 231.65, $pageOne['sectionB']['appartiene3']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 231.65, $pageOne['sectionB']['harapporti3']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 236.98, $pageOne['sectionB']['noneri3']), //non è riconducibile né all’ambito familiare né professionale1
                );
                

                if($pageOne['PresenzafisicadelCliente'] == 'si'){
                    //Presenza fisica del Cliente //SI
                    $radiobuttons[] = array(10.75, 47.5, '>');
                }else{
                    //NO
                    $radiobuttons[] = array(31.50, 47.5, '>');
                     //Se, NO //Firma Digitale
                    $radiobuttons[] = array(44.45, 53.34, $pageOne['FirmaDigitale']);
                    //Collegamento Audio/Video1)
                    $radiobuttons[] = array(71,53.34,$pageOne['CollegamentoAudio']);
                }
                if($pageOne['sectionA']['Sesso1'] == 'm'){
                    $radiobuttons[] = array(76, 81.53, '>'); //Sesso: //M
                }else{
                    $radiobuttons[] = array(82.25, 81.53, '>'); //F
                }
                if($pageOne['sectionA']['PEP31'] == 'no'){
                    $radiobuttons[] = array(22.1, 108.97, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(38, 108.97, '>'); //SI1, in qualità di
                }
                if($pageOne['sectionA']['IncarichiPubblici4'] == 'no'){
                    $radiobuttons[] = array(41.91, 115.32, '>'); //Incarichi Pubblici4 //NO
                }else{
                    $radiobuttons[] = array(58.67, 115.32, '>'); //SI1,in quanto
                }

                if($pageOne['sectionB']['PEP32'] == 'no'){
                    $radiobuttons[] = array(20.83, 165.35, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 165.35, '>'); //SI1, in qualità di
                }


                if($pageOne['sectionB']['PEP33'] == 'no'){
                    $radiobuttons[] = array(20.83, 204.22, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 204.22, '>'); //SI1, in qualità di
                }

                if($pageOne['sectionB']['PEP34'] == 'no'){
                    $radiobuttons[] = array(20.83, 242.82, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 242.82, '>'); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach($radiobuttons as $radiobutton){
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 2) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(37.08, 38.35, $pageTwo['sectionB']['Cognomeenome4']), //Cognome e nome
                    array(140.97, 38.35, $pageTwo['sectionB']['CodFisc4']), //Cod.Fisc.
                    array(32.26, 43.69, $pageTwo['sectionB']['Datadinascita4']), //Data di nascita
                    array(85.85, 43.69, $pageTwo['sectionB']['Luogodinascita4']), //Luogo di nascita
                    // array(66.29, 104.9, "5"), //SI1, in qualità di //text
                    array(36.83, 76.45, $pageTwo['sectionB']['Cognomeenome5']), //Beneficiario : //Cognome e nome
                    array(141.99, 76.45, $pageTwo['sectionB']['CodFisc5']), //Cod.Fisc.
                    array(32.77, 83.06, $pageTwo['sectionB']['Datadinascita5']), //Data di nascita
                    array(85.85, 83.06, $pageTwo['sectionB']['Luogodinascita5']), //Luogo di nascita
                    // array(128.78, 89.41, "10"), //Paesi Terzi1, quale // text
                    array(37.59, 114.81, $pageTwo['sectionB']['Cognomeenome6']), //Il Pagatore (se diverso dal contraente/aderente): //Cognome e nome
                    array(141.22, 114.81, $pageTwo['sectionB']['CodFisc6']), //Cod.Fisc.
                    array(32.51, 119.89, $pageTwo['sectionB']['Datadinascita6']), //Data di nascita
                    array(85.34, 119.89, $pageTwo['sectionB']['Luogodinascita6']), //Luogo di nascita
                    // array(125.98,126.49, "14"), //Paesi Terzi1, quale // text
                    // array(72.64, 141.73, "15"), //In ogni caso, specificare il rapporto tra le parti
                    // array(65.79, 146.81, "16"), //SI1, in qualità di // text
                    // array(133.35, 166.37, "17"), //Stato Estero1, specificare quale // text
                    array(14.73, 177.29, $pageTwo['sectionC']['Cognomeenome']), //(Cognome e nome)
                    array(74.93, 177.29, $pageTwo['sectionC']['CodiceFiscale']), //(Codice Fiscale)
                    array(136.4, 177.29, $pageTwo['sectionC']['Residenza']), //(Residenza)
                    array(14.22, 213.87, $pageTwo['sectionC']['Luogoedata']), //Luogo e data
                    // array(117.6, 213.87, "22"), //Firma del Contraente/aderente
                    
                );
                $radiobuttons = array(
                    array(45.47, 49.78, $pageTwo['sectionB']['Italia4']), //Paese di Residenza: //Italia
                    array(70.87, 49.78, $pageTwo['sectionB']['UE4']), //UE
                    array(96.01, 49.78, $pageTwo['sectionB']['PaesiTerzi1quale4']), //Paesi Terzi1, quale
                    // array(127.76, 49.78, "X"), //Paesi Terzi1, quale // text
                    array(11.18, 56.39, $pageTwo['sectionB']['appartiene4']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 56.39, $pageTwo['sectionB']['harapporti4']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 61.21, $pageTwo['sectionB']['noneri4']), //non è riconducibile né all’ambito familiare né professionale1
                    
                    array(45.97, 89.41, $pageTwo['sectionB']['Italia5']), //Paese di Residenza: //Italia
                    array(70.61, 89.41, $pageTwo['sectionB']['UE5']), //UE
                    array(96.52, 89.41, $pageTwo['sectionB']['PaesiTerzi1quale5']), //Paesi Terzi1, quale
                    array(11.43, 95, $pageTwo['sectionB']['appartiene5']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 95, $pageTwo['sectionB']['harapporti5']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 100.33, $pageTwo['sectionB']['noneri5']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(64.77, 105.41, "X"), //SI1, in qualità di // text
                    array(44.96, 126.49, $pageTwo['sectionB']['Italia6']), //Paese di Residenza: //Italia
                    array(70.61, 126.49, $pageTwo['sectionB']['UE6']), //UE
                    array(95.76, 126.49, $pageTwo['sectionB']['PaesiTerzi1quale6']), //Paesi Terzi1, quale
                    array(10.92, 131.06, $pageTwo['sectionB']['appartiene6']), //appartiene al nucleo familiare dell’Assicurato
                    array(86.61, 131.06, $pageTwo['sectionB']['harapporti6']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(10.67, 137.16, $pageTwo['sectionB']['noneri6']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(73.15, 189.99, "X"), //SI1, in qualità di // text
                );

                if($pageTwo['sectionB']['PEP35'] == 'no'){
                    $radiobuttons[] = array(20.83, 67.50, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 67.50, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP36'] == 'no'){
                    $radiobuttons[] = array(20.83, 105.41, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 105.41, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP37'] == 'no'){
                    $radiobuttons[] = array(20.07, 146.81, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 146.81, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionC']['Istitutodicredito'] == 'Italia'){
                    $radiobuttons[] = array(74.42, 166.37, ">"); //SEZIONE C – ULTERIORI INFORMAZIONI //Istituto di credito di provenienza/destinazione //Italia
                }else{
                    $radiobuttons[] = array(87.12, 166.37, ">"); //Stato Estero1, specificare quale
                }

                if($pageTwo['sectionC']['TitolareEffettivo'] == 'Unico'){
                    $radiobuttons[] = array(57.91, 172.47, ">"); //Titolare Effettivo del Rapporto: //Unico Titolare Effettivo
                }else{
                    $radiobuttons[] = array(119.63, 172.47, ">"); //Titolare Effettivo unitamente a:
                }

                if($pageTwo['sectionC']['PEP38'] == 'no'){
                    $radiobuttons[] = array(23.88, 189.99, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(44.45, 189.99, ">"); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 3) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                $cordinates = array(
                    array(29.72, 117.09, $pageThree['sectionD']['Cognome']), //Cognome
                    array(109.47, 117.09, $pageThree['sectionD']['Nome']), //Nome
                    array(71.88, 124.21, $pageThree['sectionD']['Codice']), //Codice soggetto incaricato al collocamento
                    array(143.51, 124.21, $pageThree['sectionD']['Numiscrizione']), //Num. iscrizione RUI
                    array(92.71, 130.56, $pageThree['sectionD']['Regione']), //Regione di attività del soggetto incaricato del collocamento
                    array(35.31, 137.92, $pageThree['sectionD']['Luogoedata']), //Luogo e data
                    // array(110.24, 137.92, "8"), //Timbro/Firma
                    // array(35.81, 155.19, "9"), //Validazione percorso di Adeguata Verifica //Intermediario
                    array(126.49, 155.19, $pageThree['sectionD']['TimbroFirma']), //Timbro/Firma
                    // array(84.58, 181.61, "11"), //Spazio riservato alla Compagnia //Tipo verifica sul nominativo:
                    array(33.53, 188.21, $pageThree['sectionD']['WCL']), //WCL
                    array(19.56, 199.64, $pageThree['sectionD']['Altro']), //Altro esito delle verifiche:
                    
                );
                $radiobuttons = array(
                    array(17.78, 49.78, $pageThree['sectionD']['Normale']), //Comportamento tenuto dal cliente all’instaurazione del rapporto continuativo //Normale
                    array(17.78, 54.86, $pageThree['sectionD']['Riluttanza']), //Riluttanza e/o reticenza nel fornire le informazioni richieste1
                    array(17.78, 59.18, $pageThree['sectionD']['Interposizione']), //Interposizione di soggetti terzi senza apparente giustificazione1
                    array(17.78, 64.77, $pageThree['sectionD']['Ilcliente']), //cliente mostra una inusuale familiarità con le norme antiriciclaggio1
                    array(17.78, 69.34, $pageThree['sectionD']['Altreanomalie']), //Altre anomalie comportamentali riscontrate1. Specificare
                );

                if($pageThree['sectionD']['Leinformazioni'] == 'si'){
                    $radiobuttons[] = array(107.19, 76.71, ">"); //Le informazioni ricevute dal cliente, sono da ritenersi attendibili? //Si
                }else{
                    $radiobuttons[] = array(121.92, 76.71, ">"); //No1. Specificare il motivo
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } 
        }
        // Output the new PDF
        $file_name = uniqid().'form-1';
        $pdf->Output('testing/' . $file_name . '.pdf','F');
        // Get Full Path of Generated PDF File
        $file_full_path = public_path('testing/' . $file_name . '.pdf');
        return $file_full_path;
    }

    
    // fill data in form One
    public static function generateSignPDFForm($sale)
    { 
        $pageOne = $sale;
        $date = date('Y-m-d');
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile(self::template_document_first_form);
        $pdf->SetAutoPageBreak(TRUE, 0);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);

            if($pageNo == 1) {
                //Output Name
                $cordinates = array(
                    array(18.8, 248.92, $pageOne['contractordenominazione']), //(Cognome e nome / Denominazione)
                   
                );
                $radiobuttons = array(
                    array(11.94, 221.49, ""),//Paese di Residenza: //Italia
                    array(61.98, 221.49, ""), 
                );
                if($pageOne['contractordiamoilconsenso']){
                    $radiobuttons[] = array(12.68, 225.81, "4"); //Le informazioni ricevute dal cliente, sono da ritenersi attendibili? //Si
                }else{
                    $radiobuttons[] = array(12.68, 221.81, "");
                }

                if($pageOne['contractorneghiamoilconsenso']){
                    $radiobuttons[] = array(61.98, 225.81, "4"); //Le informazioni ricevute dal cliente, sono da ritenersi attendibili? //Si
                }else{
                    $radiobuttons[] = array(61.98, 225.81, "");
                }
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                $pdf->SetFont('ZapfDingbats','', 10);
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
                
            } else if ($pageNo == 2) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(60.2, 184.15, $pageOne['contractordenominazione']),//Cognome e nome
                    array(64.26, 191.52, $pageOne['contractorComunediNascita']),
                    array(104.65, 191.52, $pageOne['contractorProvinciadiNascita']),
                    array(32.26, 198.63, $pageOne['contractorCodiceFiscale']), 
                    array(119.89, 198.88, $pageOne['contractorPartitaIva']), 
                    array(26.67, 220.73, $pageOne['contractorIndirizzo']), 
                    array(33.02, 228.09, $pageOne['contractorCAP']), 
                    array(81.03, 228.09, $pageOne['contractorCitta']), 
                    array(154.94,228.09, $pageOne['contractorProvincia']), 
                ); 

              
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
            } else if ($pageNo == 4) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(20.32, 247.65, $pageOne['contractordenominazione'])   
                );

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
            } else if($pageNo == 5){
                $cordinates = array(
                    array(59.44, 18.29, $pageOne['contractordenominazione']),//Cognome e nome
                    array(64.01, 25.91, $pageOne['contractorComunediNascita']),
                    array(103.63, 25.91, $pageOne['contractorProvinciadiNascita']),
                    array(32.00, 33.27, $pageOne['contractorCodiceFiscale']), 
                    array(119.13, 33.27, $pageOne['contractorPartitaIva']), 
                    array(23.62, 52.32, $pageOne['contractorIndirizzo']), 
                    array(35.05, 61.21, $pageOne['contractorCAP']), 
                    array(79.05, 61.21, $pageOne['contractorCitta']), 
                    array(155.19,61.21, $pageOne['contractorProvincia']), 
                );
                
                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }    

            } 
        }
        // Output the new PDF
        $file_name = uniqid().'form-new';
        $pdf->Output('testing/' . $file_name . '.pdf','F');
        // Get Full Path of Generated PDF File
        $file_full_path = public_path('testing/' . $file_name . '.pdf');
        return $file_full_path;
    }
    // fill data in form One
    public static function generateSignPDFFormFirst($sale)
    {

        $pageOne = $sale['personalInfo']['pageOne'];
        $pageTwo = $sale['personalInfo']['pageTwo'];
        $pageThree = $sale['personalInfo']['pageThree'];
        $date = date('Y-m-d');
        $pdf = new \setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile(self::template_document_file_one);
        $pdf->SetAutoPageBreak(TRUE, 0);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // get the size of the imported page
            $size = $pdf->getTemplateSize($templateId);
            // create a page (landscape or portrait depending on the imported page size)
            if ($size['orientation'] == 'L') {
                $pdf->AddPage('L', array($size['width'], $size['height']));
            } else {
                $pdf->AddPage('P', array($size['width'], $size['height']));
            }

            // use the imported page
            $pdf->useTemplate($templateId);

            if($pageNo == 1) {
                //Output Name
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                $cordinates = array(
                    array(44.96, 27.94, $pageOne['CodiceIntermediario']), //Codice Intermediario
                    array(94.74, 27.94, $pageOne['SottoCodice']), //Sotto-codice
                    array(173.48, 30.73, $date), //Data
                    array(37.59, 70.1, $pageOne['sectionA']['Cognomeenome1']), //SEZIONE A - DATI IDENTIFICATIVI DEL CONTRAENTE /ADERENTE //Cognome e nome
                    array(32.51, 75.44, $pageOne['sectionA']['Datadinascita1']), //Data di nascita
                    array(72.39, 75.44, $pageOne['sectionA']['Luogodinascita1']), //Luogo di nascita
                    array(153.16, 75.44, $pageOne['sectionA']['Nazionalità1']), //Nazionalità
                    array(25.4, 81.53, $pageOne['sectionA']['formCodFisc1']), //Cod.Fisc.
                    array(114.55, 81.28, $pageOne['sectionA']['Tipodocdiidentita1']), //Tipo doc. di identità
                    array(16.76, 86.87, $pageOne['sectionA']['N1']), //N.
                    array(51.05, 86.87, $pageOne['sectionA']['Rilasciatoil1']), //Rilasciato il
                    array(73.15, 86.87, $pageOne['sectionA']['da1']), //da
                    array(37.59, 92.46, $pageOne['sectionA']['Localitadirilascio1']), //Località di rilascio
                    array(161.8, 92.2, $pageOne['sectionA']['Datascadenzadocidentita1']), //Data scadenza doc. identità
                    array(42.16, 98.3, $pageOne['sectionA']['Indirizzodiresidenza1']), //Indirizzo di residenza
                    array(133.35, 98.3, $pageOne['sectionA']['CAP1']), //CAP
                    array(157.48, 98.3, $pageOne['sectionA']['Prov1']), //Prov.
                    array(175.51, 98.3, $pageOne['sectionA']['Stato21']), //Stato2
                    array(26.16, 103.63, $pageOne['sectionA']['Telefono1']), //Telefono
                    array(117.09, 103.63, $pageOne['sectionA']['Mail1']), //Mail
                    array(65.02, 108.97, $pageOne['sectionA']['inqualitadi1']), //SI1, in qualità di // text
                    array(81.03, 115.32, $pageOne['sectionA']['inquanto1']), //SI1,in quanto // text
                    array(36.07, 135.89, $pageOne['sectionB']['Cognomeenome1']), //SEZIONE B – ALTRI SOGGETTI //Cognome e nome
                    array(141.73, 135.89, $pageOne['sectionB']['CodFisc1']), //Cod.Fisc
                    array(32, 142.24,  $pageOne['sectionB']['Datadinascita1']), //Data di nascita
                    array(85.85, 142.24, $pageOne['sectionB']['Luogodinascita1']), //Luogo di nascita
                    // array(127.51, 148.59, '27'), //Paesi Terzi1, quale //text
                    // array(63.5, 165.35, '28'), //SI1, in qualità di //text
                    array(36.58, 175.01, $pageOne['sectionB']['Cognomeenome2']), //Cognome e nome
                    array(141.48, 175.51, $pageOne['sectionB']['CodFisc2']), //Cod.Fisc.
                    array(32.77, 180.85, $pageOne['sectionB']['Datadinascita2']), //Data di nascita
                    array(86.36, 181.36, $pageOne['sectionB']['Luogodinascita2']), //Luogo di nascita
                    // array(125.98, 187.45, '33'), //Paesi Terzi1, quale // text
                    // array(64.26, 204.22, '34'), //SI1, in qualità di // text
                    array(35.31, 213.87, $pageOne['sectionB']['Cognomeenome3']), //Cognome e nome
                    array(141.73, 213.87, $pageOne['sectionB']['CodFisc3']), //Cod.Fisc.
                    array(32.77, 219.71, $pageOne['sectionB']['Datadinascita3']), //Data di nascita
                    array(86.11, 219.71, $pageOne['sectionB']['Luogodinascita3']), //Luogo di nascita
                    // array(125.98, 225.81, '39'), //Paesi Terzi1, quale // text
                    // array(65.28, 242.82, '40'), //SI1, in qualità di //text
                );

                //radio button cordinates
                $radiobuttons = array(
                    array(46.74, 148.59, $pageOne['sectionB']['Italia1']), //Paese di Residenza: //Italia
                    array(71.88, 148.59, $pageOne['sectionB']['UE1']), //UE
                    array(96.77, 148.59, $pageOne['sectionB']['PaesiTerzi1quale1']), //Paesi Terzi1, quale
                    array(11.94, 154.69, $pageOne['sectionB']['appartiene1']), //appartiene al nucleo familiare dell’Assicurato
                    array(88.14, 154.69, $pageOne['sectionB']['harapporti1']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.94, 160.02, $pageOne['sectionB']['noneri1']), //non è riconducibile né all’ambito familiare né professionale1
                    array(45.97, 187.45, $pageOne['sectionB']['Italia2']), //Paese di Residenza: //Italia
                    array(71.37, 187.45, $pageOne['sectionB']['UE2']), //UE
                    array(96.77, 187.45, $pageOne['sectionB']['PaesiTerzi1quale2']), //Paesi Terzi1, quale
                    array(11.68, 193.04, $pageOne['sectionB']['appartiene2']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 193.04, $pageOne['sectionB']['harapporti2']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 198.63, $pageOne['sectionB']['noneri2']), //non è riconducibile né all’ambito familiare né professionale1
                    array(46.23, 225.81, $pageOne['sectionB']['Italia3']), //Paese di Residenza: //Italia
                    array(71.12, 225.81, $pageOne['sectionB']['UE3']), //UE
                    array(96.52, 225.81, $pageOne['sectionB']['PaesiTerzi1quale3']), //Paesi Terzi1, quale
                    array(11.68, 231.65, $pageOne['sectionB']['appartiene3']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 231.65, $pageOne['sectionB']['harapporti3']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.68, 236.98, $pageOne['sectionB']['noneri3']), //non è riconducibile né all’ambito familiare né professionale1
                );
                

                if($pageOne['PresenzafisicadelCliente'] == 'si'){
                    //Presenza fisica del Cliente //SI
                    $radiobuttons[] = array(10.75, 47.5, '>');
                }else{
                    //NO
                    $radiobuttons[] = array(31.50, 47.5, '>');
                     //Se, NO //Firma Digitale
                    $radiobuttons[] = array(44.45, 53.34, $pageOne['FirmaDigitale']);
                    //Collegamento Audio/Video1)
                    $radiobuttons[] = array(71,53.34,$pageOne['CollegamentoAudio']);
                }
                if($pageOne['sectionA']['Sesso1'] == 'm'){
                    $radiobuttons[] = array(76, 81.53, '>'); //Sesso: //M
                }else{
                    $radiobuttons[] = array(82.25, 81.53, '>'); //F
                }
                if($pageOne['sectionA']['PEP31'] == 'no'){
                    $radiobuttons[] = array(22.1, 108.97, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(38, 108.97, '>'); //SI1, in qualità di
                }
                if($pageOne['sectionA']['IncarichiPubblici4'] == 'no'){
                    $radiobuttons[] = array(41.91, 115.32, '>'); //Incarichi Pubblici4 //NO
                }else{
                    $radiobuttons[] = array(58.67, 115.32, '>'); //SI1,in quanto
                }

                if($pageOne['sectionB']['PEP32'] == 'no'){
                    $radiobuttons[] = array(20.83, 165.35, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 165.35, '>'); //SI1, in qualità di
                }


                if($pageOne['sectionB']['PEP33'] == 'no'){
                    $radiobuttons[] = array(20.83, 204.22, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 204.22, '>'); //SI1, in qualità di
                }

                if($pageOne['sectionB']['PEP34'] == 'no'){
                    $radiobuttons[] = array(20.83, 242.82, '>'); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 242.82, '>'); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach($radiobuttons as $radiobutton){
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 2) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    array(37.08, 38.35, $pageTwo['sectionB']['Cognomeenome4']), //Cognome e nome
                    array(140.97, 38.35, $pageTwo['sectionB']['CodFisc4']), //Cod.Fisc.
                    array(32.26, 43.69, $pageTwo['sectionB']['Datadinascita4']), //Data di nascita
                    array(85.85, 43.69, $pageTwo['sectionB']['Luogodinascita4']), //Luogo di nascita
                    // array(66.29, 104.9, "5"), //SI1, in qualità di //text
                    array(36.83, 76.45, $pageTwo['sectionB']['Cognomeenome5']), //Beneficiario : //Cognome e nome
                    array(141.99, 76.45, $pageTwo['sectionB']['CodFisc5']), //Cod.Fisc.
                    array(32.77, 83.06, $pageTwo['sectionB']['Datadinascita5']), //Data di nascita
                    array(85.85, 83.06, $pageTwo['sectionB']['Luogodinascita5']), //Luogo di nascita
                    // array(128.78, 89.41, "10"), //Paesi Terzi1, quale // text
                    array(37.59, 114.81, $pageTwo['sectionB']['Cognomeenome6']), //Il Pagatore (se diverso dal contraente/aderente): //Cognome e nome
                    array(141.22, 114.81, $pageTwo['sectionB']['CodFisc6']), //Cod.Fisc.
                    array(32.51, 119.89, $pageTwo['sectionB']['Datadinascita6']), //Data di nascita
                    array(85.34, 119.89, $pageTwo['sectionB']['Luogodinascita6']), //Luogo di nascita
                    array(14.73, 177.29, $pageTwo['sectionC']['Cognomeenome']), //(Cognome e nome)
                    array(74.93, 177.29, $pageTwo['sectionC']['CodiceFiscale']), //(Codice Fiscale)
                    array(136.4, 177.29, $pageTwo['sectionC']['Residenza']), //(Residenza)
                    array(14.22, 213.87, $pageTwo['sectionC']['Luogoedata']), //Luogo e data
                    
                );
                $radiobuttons = array(
                    array(45.47, 49.78, $pageTwo['sectionB']['Italia4']), //Paese di Residenza: //Italia
                    array(70.87, 49.78, $pageTwo['sectionB']['UE4']), //UE
                    array(96.01, 49.78, $pageTwo['sectionB']['PaesiTerzi1quale4']), //Paesi Terzi1, quale
                    // array(127.76, 49.78, "X"), //Paesi Terzi1, quale // text
                    array(11.18, 56.39, $pageTwo['sectionB']['appartiene4']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 56.39, $pageTwo['sectionB']['harapporti4']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 61.21, $pageTwo['sectionB']['noneri4']), //non è riconducibile né all’ambito familiare né professionale1
                    
                    array(45.97, 89.41, $pageTwo['sectionB']['Italia5']), //Paese di Residenza: //Italia
                    array(70.61, 89.41, $pageTwo['sectionB']['UE5']), //UE
                    array(96.52, 89.41, $pageTwo['sectionB']['PaesiTerzi1quale5']), //Paesi Terzi1, quale
                    array(11.43, 95, $pageTwo['sectionB']['appartiene5']), //appartiene al nucleo familiare dell’Assicurato
                    array(87.63, 95, $pageTwo['sectionB']['harapporti5']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(11.18, 100.33, $pageTwo['sectionB']['noneri5']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(64.77, 105.41, "X"), //SI1, in qualità di // text
                    array(44.96, 126.49, $pageTwo['sectionB']['Italia6']), //Paese di Residenza: //Italia
                    array(70.61, 126.49, $pageTwo['sectionB']['UE6']), //UE
                    array(95.76, 126.49, $pageTwo['sectionB']['PaesiTerzi1quale6']), //Paesi Terzi1, quale
                    array(10.92, 131.06, $pageTwo['sectionB']['appartiene6']), //appartiene al nucleo familiare dell’Assicurato
                    array(86.61, 131.06, $pageTwo['sectionB']['harapporti6']), //ha rapporti professionali o d’affari con l’Assicurato
                    array(10.67, 137.16, $pageTwo['sectionB']['noneri6']), //non è riconducibile né all’ambito familiare né professionale1
                    // array(73.15, 189.99, "X"), //SI1, in qualità di // text
                );

                if($pageTwo['sectionB']['PEP35'] == 'no'){
                    $radiobuttons[] = array(20.83, 67.50, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 67.50, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP36'] == 'no'){
                    $radiobuttons[] = array(20.83, 105.41, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 105.41, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionB']['PEP37'] == 'no'){
                    $radiobuttons[] = array(20.07, 146.81, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(37.59, 146.81, ">"); //SI1, in qualità di
                }

                if($pageTwo['sectionC']['Istitutodicredito'] == 'Italia'){
                    $radiobuttons[] = array(74.42, 166.37, ">"); //SEZIONE C – ULTERIORI INFORMAZIONI //Istituto di credito di provenienza/destinazione //Italia
                }else{
                    $radiobuttons[] = array(87.12, 166.37, ">"); //Stato Estero1, specificare quale
                }

                if($pageTwo['sectionC']['TitolareEffettivo'] == 'Unico'){
                    $radiobuttons[] = array(57.91, 172.47, ">"); //Titolare Effettivo del Rapporto: //Unico Titolare Effettivo
                }else{
                    $radiobuttons[] = array(119.63, 172.47, ">"); //Titolare Effettivo unitamente a:
                }

                if($pageTwo['sectionC']['PEP38'] == 'no'){
                    $radiobuttons[] = array(23.88, 189.99, ">"); //PEP3 //NO
                }else{
                    $radiobuttons[] = array(44.45, 189.99, ">"); //SI1, in qualità di
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } else if ($pageNo == 3) {
                $pdf->SetFont('Helvetica');
                $pdf->SetFontSize(6);
                // $current_location = self::get_client_location();
                // $date_location_str = date("d/m/Y") . '  ' . $current_location['country'];
                $cordinates = array(
                    // array(99.57, 69.34, "1"), //Altre anomalie comportamentali riscontrate1. Specificare // text
                    // array(160.02, 76.71, "1"), //No1. Specificare il motivo // text
                    array(29.72, 117.09, $pageThree['sectionD']['Cognome']), //Cognome
                    array(109.47, 117.09, $pageThree['sectionD']['Nome']), //Nome
                    array(71.88, 124.21, $pageThree['sectionD']['Codice']), //Codice soggetto incaricato al collocamento
                    array(143.51, 124.21, $pageThree['sectionD']['Numiscrizione']), //Num. iscrizione RUI
                    array(92.71, 130.56, $pageThree['sectionD']['Regione']), //Regione di attività del soggetto incaricato del collocamento
                    array(35.31, 137.92, $pageThree['sectionD']['Luogoedata']), //Luogo e data
                    // array(110.24, 137.92, "8"), //Timbro/Firma
                    // array(35.81, 155.19, "9"), //Validazione percorso di Adeguata Verifica //Intermediario
                    array(126.49, 155.19, $pageThree['sectionD']['TimbroFirma']), //Timbro/Firma
                    // array(84.58, 181.61, "11"), //Spazio riservato alla Compagnia //Tipo verifica sul nominativo:
                    array(33.53, 188.21, $pageThree['sectionD']['WCL']), //WCL
                    array(19.56, 199.64, $pageThree['sectionD']['Altro']), //Altro esito delle verifiche:
                    
                );
                $radiobuttons = array(
                    array(17.78, 49.78, $pageThree['sectionD']['Normale']), //Comportamento tenuto dal cliente all’instaurazione del rapporto continuativo //Normale
                    array(17.78, 54.86, $pageThree['sectionD']['Riluttanza']), //Riluttanza e/o reticenza nel fornire le informazioni richieste1
                    array(17.78, 59.18, $pageThree['sectionD']['Interposizione']), //Interposizione di soggetti terzi senza apparente giustificazione1
                    array(17.78, 64.77, $pageThree['sectionD']['Ilcliente']), //cliente mostra una inusuale familiarità con le norme antiriciclaggio1
                    array(17.78, 69.34, $pageThree['sectionD']['Altreanomalie']), //Altre anomalie comportamentali riscontrate1. Specificare
                );

                if($pageThree['sectionD']['Leinformazioni'] == 'si'){
                    $radiobuttons[] = array(107.19, 76.71, ">"); //Le informazioni ricevute dal cliente, sono da ritenersi attendibili? //Si
                }else{
                    $radiobuttons[] = array(121.92, 76.71, ">"); //No1. Specificare il motivo
                }

                foreach($cordinates as $cordinate){
                    self::writeXY($pdf, $cordinate[0], $cordinate[1], $cordinate[2]);
                }
                foreach ($radiobuttons as $radiobutton) {
                    self::writeXY($pdf, $radiobutton[0], $radiobutton[1], $radiobutton[2]);
                }
            } 
        }
        // Output the new PDF
        $file_name = uniqid().'form-1';
        $pdf->Output('testing/' . $file_name . '.pdf','F');
        // Get Full Path of Generated PDF File
        $file_full_path = public_path('testing/' . $file_name . '.pdf');
        return $file_full_path;
    }

    public static function writeXY(\setasign\Fpdi\Fpdi $pdf, $x, $y, $text){
        $pdf->SetXY($x, $y);
        $pdf->Write(4, $text);
    }
}
