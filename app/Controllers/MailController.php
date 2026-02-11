<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\GatepassMailLogModel;
use App\Controllers\WhatsappController;

class MailController extends Controller
{
    

        public function sendMail()
        {
            try {
                $resendVId = $this->request->getPost();
                $request_head_id = $this->request->getPost('head_id');
                $headerModel = new \App\Models\VisitorRequestHeaderModel();
                $GatepassMailLogModel = new GatepassMailLogModel(); // Mail  Log Model
                $whatsapp = new WhatsappController(); //Whatsapp Controller


                $mailType = "";
                if(isset($resendVId['re_send']) && $resendVId['re_send'] != ''){
                    $data = $headerModel->getHeaderWithVisitorsMailDataByVCode($resendVId);
                    $mailType = 'Resend';
                } else {
                    $data = $headerModel->getHeaderWithVisitorsMailData($request_head_id);
                    $mailType = 'Approval Send';
                    // print_r($data);
                }
                $emailService = \Config\Services::email();
                $successCount = 0;
                $failed = [];
                $status = 'FAILED';
                $error  = null;

                foreach($data as $row){

                    $email = $row['visitor_email'];
                    //  print_r($row);
                    //  Generate PDF from HTML
                    $html = view('emails/gate_pass_layout', ['mailData' => $row]);

                    $options = new Options();
                    $options->set('isRemoteEnabled', true); // enable external images
                    $options->set('defaultFont', 'DejaVu Sans');
                    $options->set('chroot', FCPATH); // ?? THIS IS THE KEY FIX

                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($html);
                    $dompdf->setPaper([0, 0, 400, 550]); // custom card size
                    $dompdf->render();
                    
                    // Save PDF to file
                    $pdfDir = FCPATH . 'public/uploads/gate_pass_pdf/';
                    if(!is_dir($pdfDir)) mkdir($pdfDir, 0777, true);

                    $pdfFile = $pdfDir . 'GatePass_' . $row['v_code'] . '.pdf';
                    // Check if file exists, then delete
                    if (file_exists($pdfFile)) {
                    unlink($pdfFile);
                    }
                    // Save new PDF
                    file_put_contents($pdfFile, $dompdf->output());

                    //////////////======= Send Whatsapp ===========////////////
                    $pdfUrl = 'https://access360.ramojifilmcity.com/public/uploads/gate_pass_pdf/GatePass_V00000092.pdf';
                    // $pdfUrl = base_url('public/uploads/gate_pass_pdf/GatePass_' . $row['v_code'] . '.pdf');
                    $mobileNo =  $row['visitor_phone'];   
                    $waResponse = $whatsapp->send($mobileNo,$pdfUrl);
                    print_r($waResponse);
                   
                    /////////======== Send Email ==========/////////////////////
        
                    $emailService->clear(true);
                    $emailService->setTo($email);
                    $emailService->setFrom(env('app.email.fromEmail'), env('app.email.fromName'));
                    $emailService->setSubject("Your Visitor Gate Pass");
                    $emailService->setMessage("Dear Visitor,<br><br>Please find your Gate Pass attached.<br><br>Regards,<br>Security Team");
                    $emailService->attach($pdfFile);

                    if($emailService->send()){
                        $status = 'SENT';
                        $successCount++;
                        // =====GATE PASS MAIL LOG  =====
                        $GatepassMailLogModel->insert([
                            'request_id'    => $row['id'],
                            'v_code'        => $row['v_code'],
                            'mail_type'     => ($mailType === 'Resend') ? 'GATE_PASS_RESEND' : 'GATE_PASS',
                            'email_to'      => $email,
                            'subject'       => 'Your Visitor Gate Pass',
                            'status'        => $status,
                            'error_message' => $error,
                            'sent_by'       => session()->get('user_id'),
                            'sent_at'       => date('Y-m-d H:i:s')
                        ]);
                        
                    } else {
                        // =====GATE PASS MAIL LOG  =====
                        $GatepassMailLogModel->insert([
                            'request_id'    => $row['id'],
                            'v_code'        => $row['v_code'],
                            'mail_type'     => ($mailType === 'Resend') ? 'GATE_PASS_RESEND' : 'GATE_PASS',
                            'email_to'      => $email,
                            'subject'       => 'Your Visitor Gate Pass',
                            'status'        => $status,
                            'error_message' => $error,
                            'sent_by'       => session()->get('user_id'),
                            'sent_at'       => date('Y-m-d H:i:s')
                        ]);
                        $error  = $emailService->printDebugger();
                    }
               
                
                    }
              
                return $this->response->setJSON([
                    "status" => "success",
                    "sendType" => $mailType,
                    "message" => "Mail process completed",
                    "sent" => $successCount,
                    "failed" => $failed
                ]);

            } catch (\Exception $e){

                $GatepassMailLogModel->insert([
                    'request_id'    => $row['id'],
                    'v_code'        => $row['v_code'],
                    'mail_type'     => ($mailType === 'Resend') ? 'GATE_PASS_RESEND' : 'GATE_PASS',
                    'email_to'      => $email,
                    'subject'       => 'Your Visitor Gate Pass',
                    'status'        => $status,
                    'error_message' => $e->getMessage(),
                    'sent_by'       => session()->get('user_id'),
                    'sent_at'       => date('Y-m-d H:i:s')
                ]);

                return $this->response->setJSON([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
            }
        }

    

        /////////////////////////////group QR ////////////////////////////////

        public function sendGroupQrMail()
        {

            try {

                $head_id = $this->request->getPost('head_id');
                $email = $this->request->getPost('email');
                $GatepassMailLogModel = new GatepassMailLogModel(); // Mail  Log Model
                $mailType = ($this->request->getPost('mailType') === 're_send') ? 'Resend' : 'Approve';

                $status = 'SENT';
                $error  = null;
                
                if (!$head_id) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'Head ID is required'
                    ]);
                }

                // Fetch visitors under head_id
                $headerModel = new \App\Models\VisitorRequestHeaderModel();
                $visitors = $headerModel->getHeaderWithVisitorsMailData($head_id);

                if (empty($visitors)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'No visitors found'
                    ]);
                }

                // print_r($visitors);

                // Directories
                $pdfDir = FCPATH . 'public/uploads/group_qr/';
                if (!is_dir($pdfDir)) {
                    mkdir($pdfDir, 0755, true);
                }

                /**
                 * ==================================================
                 * LOAD GROUP QR HTML (MULTIPLE CARDS)
                 * ==================================================
                 */
                $html = view('emails/group_gatepass_layout', [
                    'visitors' => $visitors
                ]);

                /**
                 * ==================================================
                 * GENERATE PDF
                 * ==================================================
                 */
                $options = new Options();
                $options->set('isRemoteEnabled', true); // IMPORTANT (local images)
                $options->set('defaultFont', 'DejaVu Sans');
                $options->set('chroot', FCPATH); // ?? THIS IS THE KEY FIX
                
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                /**
                 * ==================================================
                 * SAVE PDF
                 * ==================================================
                 */
                $pdfFile = $pdfDir . 'Group_QR_' .$visitors[0]['header_code']. '.pdf';

                if (file_exists($pdfFile)) {
                    unlink($pdfFile);
                }

                file_put_contents($pdfFile, $dompdf->output());

                /**
                 * ==================================================
                 * SEND MAIL (SAME AS SINGLE QR STYLE)
                 * ==================================================
                 */
                $emailService = \Config\Services::email();
                $emailService->clear(true);

                $emailService->setFrom(
                    env('app.email.fromEmail'),
                    env('app.email.fromName')
                );

                // Change TO if required
                // $emailService->setTo($visitors[0]['visitor_email']);
                $emailService->setTo($email);

                $emailService->setSubject('Group Visitor Gate Pass');
                $emailService->setMessage(
                    "Dear Team,<br><br>
                    Please find attached the group visitor gate passes.<br><br>
                    Regards,<br>Security Team"
                );

                $emailService->attach($pdfFile);

                if(!$emailService->send()){
                    $status = 'FAILED';
                    $error =  $emailService->printDebugger();
                    
                $GatepassMailLogModel->insert([
                    'request_id'    => $visitors[0]['id'],
                    'v_code'        => $visitors[0]['header_code'],
                    'mail_type'     => ($mailType === 'Resend') ? 'GROUP_GATE_PASS_RESEND' : 'GROUP_GATE_PASS',
                    'email_to'      => $email,
                    'subject'       => 'Your Visitor Gate Pass',
                    'status'        => $status,
                    'error_message' => $emailService->printDebugger(),
                    'sent_by'       => session()->get('user_id'),
                    'sent_at'       => date('Y-m-d H:i:s')
                ]);


                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => $emailService->printDebugger()
                    ]);
                }
                    $GatepassMailLogModel->insert([
                        'request_id'    => $visitors[0]['id'],
                        'v_code'        => $visitors[0]['header_code'],
                        'mail_type'     => ($mailType === 'Resend') ? 'GROUP_GATE_PASS_RESEND' : 'GROUP_GATE_PASS',
                        'email_to'      => $email,
                        'subject'       => 'Your Visitor Gate Pass',
                        'status'        => $status,
                        'error_message' => null,
                        'sent_by'       => session()->get('user_id'),
                        'sent_at'       => date('Y-m-d H:i:s')
                    ]);


                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Group QR mail sent successfully',
                 
                ]);

            } catch (\Exception $e) {

               $GatepassMailLogModel->insert([
                    'request_id'    => $visitors[0]['id'],
                    'v_code'        => $visitors[0]['header_code'],
                    'mail_type'     => ($mailType === 'Resend') ? 'GROUP_GATE_PASS_RESEND' : 'GROUP_GATE_PASS',
                    'email_to'      => $email,
                    'subject'       => 'Your Visitor Gate Pass',
                    'status'        => $status,
                    'error_message' => $e->getMessage(),
                    'sent_by'       => session()->get('user_id'),
                    'sent_at'       => date('Y-m-d H:i:s')
                ]);

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]);
            }
        }



        /////////////////////////////Recce Mail////////////////////////////////

        public function recceMail($data)
        {
            try {

                $emailService = \Config\Services::email();

                // UT email
                $utEmail = 'karnamahesh42@gmail.com';
                $row = $data[0];  
                $message = "
                    <p>Dear UT Team,</p>

                    <p>
                    This is a <strong>system-generated notification</strong> to inform you that a
                    <strong>Recce Visit</strong> has been scheduled. Kindly review the details below
                    and make the necessary arrangements.
                    </p>

                    <p>
                    <strong>Request No:</strong> {$row['header_code']}<br>
                    <strong>Company:</strong> {$row['company']}<br>
                    <strong>Department:</strong> {$row['department_name']}<br>
                    <strong>Total Visitors:</strong> {$row['total_visitors']}<br>
                    <strong>Visit Date:</strong> {$row['visit_date']}<br>
                    <strong>Recce Type:</strong> {$row['recce_type']}<br>
                    <strong>Company / Production:</strong> {$row['productio']}<br>
                    <strong>Art Director / Director:</strong> {$row['art_director']}<br>
                    <strong>Tentative Date:</strong> {$row['shooting_date']}<br>
                    <strong>Contact Person:</strong> {$row['contact_person']}
                    </p>

                    <p>
                    Please note that this is an <strong>automated email</strong> sent for
                    notification purposes. Replies to this email are not required.
                    </p>

                    <p>
                    Regards,<br>
                    <strong>Security Team</strong>
                    </p>
                ";


                $emailService->clear(true);
                $emailService->setTo($utEmail);
                $emailService->setFrom(
                    env('app.email.fromEmail'),
                    env('app.email.fromName')
                );
                $emailService->setSubject("Recce Visit Scheduled on {$row['visit_date']} – {$row['recce_type']}");
                $emailService->setMessage($message);

                if (!$emailService->send()) {
                    echo "<pre>";
                    print_r($emailService->printDebugger());
                    exit;
                }

                echo "UT Mail sent successfully";
                exit;

            } catch (\Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

}
