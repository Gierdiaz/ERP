<?php

namespace App\Http\Controllers;

use Dompdf\{Dompdf};
use Illuminate\Support\Facades\View;
use TCPDF;

class DocumentController extends Controller
{
    public function createPDF()
    {
        // Carregar a view Blade
        $html = View::make('exemplo_pdf', [
            'paciente' => [
                'nome'  => 'Fulano de Tal',
                'idade' => 30,
                'sexo'  => 'Masculino',
                'cpf'   => '123.456.789-00',
            ],
            'medico' => 'Dr. José da Silva',
            'exames' => [
                ['nome' => 'Pressão Arterial', 'resultado' => '120/80 mmHg'],
                ['nome' => 'Glicemia', 'resultado' => '90 mg/dL'],
                ['nome' => 'Colesterol Total', 'resultado' => '180 mg/dL'],
            ],
        ])->render();

        // Configurações do Dompdf
        $options = new \Dompdf\Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Criação do Dompdf
        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);

        // Renderização do PDF
        $dompdf->render();

        // Obtenha o conteúdo do PDF
        $pdfContent = $dompdf->output();

        // Caminho do certificado
        $certificate = file_get_contents(base_path('your_certificate.crt'));

        // Carregue manualmente a chave privada
        $privateKey = file_get_contents(base_path('chave_teste.pem'));
        $passphrase = ''; // Se a chave privada tiver uma senha, forneça aqui

        // Crie um novo PDF com TCPDF
        $tcpdf = new TCPDF();

        // Adicione a assinatura digital
        $signature = [
            'page'       => 1, // Página para colocar a assinatura (1 é a primeira página)
            'x'          => 10, // Posição horizontal
            'y'          => 10, // Posição vertical
            'image'      => '', // Caminho da imagem de assinatura (opcional)
            'is_file'    => false, // Se a imagem é um arquivo ou uma string (opcional)
            'is_url'     => false, // Se a imagem é uma URL ou uma string (opcional)
            'is_string'  => true, // Se a imagem é uma string (opcional)
            'sig_object' => [
                'Name'            => 'sig1',
                'ContactInfo'     => 'http://example.com/contact',
                'Reason'          => 'I am the author',
                'Location'        => 'Lisbon',
                'SignatureMethod' => 'adbe.pkcs7.detached',
                'M'               => date('Y-m-d H:i:s'), // M - the time of signing (optional)
            ],
            'info' => [
                'Name'     => 'TCPDF',
                'Location' => 'Office',
                'Reason'   => 'Testing TCPDF',
            ],
        ];

        // $tcpdf->setSignature($certificate, $privateKey, $passphrase, '', 1, $signature); // Configure conforme necessário
        $tcpdf->setSignature($certificate, '', 'Rosilane1204', '', 0, $signature);

        // Adicione o conteúdo do PDF gerado pelo Dompdf ao TCPDF
        $tcpdf->AddPage();
        $tcpdf->writeHTML($html, true, false, true, false, '');

        // Renderize o PDF
        $pdfContentWithSignature = $tcpdf->Output('', 'S');

        // Retorne a resposta HTTP com o PDF como anexo
        return response($pdfContentWithSignature)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="documento_assinado.pdf"');
    }
}
