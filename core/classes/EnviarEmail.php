<?php
namespace core\classes;

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;

        class EnviarEmail
        {
            public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl){
                //envia email confirmacao
                $link = BASE_URL . '?a=confirmar_email&purl='.$purl;
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = EMAIL_HOST;                     
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = EMAIL_FROM;                     
                    $mail->Password   = EMAIL_PASS;                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                    $mail->Port       = EMAIL_PORT;      
                    $mail->Charset   = 'UTF-8';                              

                    //Recipients
                    $mail->setFrom(EMAIL_FROM, APP_NAME);
                    $mail->addAddress($email_cliente, 'Joe User');    
                                                    
                    //Content
                    $mail->isHTML(true);                                  
                    $mail->Subject = APP_NAME . ' confirmação de email.';
                    $html = '<p>Seja bem vindo a nossa loja ' . APP_NAME . '. </p>';
                    $html .= '<p>Para poder entrar em nossa loja, precisamos confirmar seu email';
                    $html .= '<p>Para confirmar o email click no link abaixo....</p>';
                    $html .= '<p><a href="'.$link. '">confirmar Email</a></p>';
                    $html .= '<p><i><small>'. APP_NAME . '</small></i></p>';
                    $mail->Body = $html;                   

                    $mail->send();
                    return true;
                } catch (Exception $e) {
                   return false;
                }

            }

            public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda){
               
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = EMAIL_HOST;                     
                    $mail->SMTPAuth   = true;                                  
                    $mail->Username   = EMAIL_FROM;                     
                    $mail->Password   = EMAIL_PASS;                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                    $mail->Port       = EMAIL_PORT;      
                    $mail->Charset   = 'utf-8';                              

                    //Recipients
                    $mail->setFrom(EMAIL_FROM, APP_NAME);
                    $mail->addAddress($email_cliente, 'Joe User');    
                                                    
                    //Content
                    $mail->isHTML(true);                                  
                    $mail->Subject = APP_NAME . ' confirmação de encomenda - ' . $dados_encomenda['dados_pagamento']['codigo_encomenda'];
                    $html = '<p>Obrigado por sua compra na nossa loja ' . APP_NAME . '. </p>';
                    $html .= '<ul>';
                    foreach ($dados_encomenda['lista_produtos'] as $produtos) {
                        $html .="<li> $produtos </li>";                      
                    };
                    $html .= '</ul>';

                    $html .= '<p><i>Total : <strong>'. $dados_encomenda['total']. '</strong></i></p>';
                    
                    $html .= '<p><strong> DADOS DE PAGAMENTO </strong></p>';
                    $html .= '<p><i>Conta : <strong>'. $dados_encomenda['dados_pagamento']['conta']. '</strong></i></p>';
                    
                    $mail->Body = $html;                   

                    $mail->send();
                    return true;
                } catch (Exception $e) {
                   return false;
                }

            }



                
        }         