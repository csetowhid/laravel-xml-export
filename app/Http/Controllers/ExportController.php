<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Digitick\Sepa\DomBuilder\DomBuilderFactory;
use Digitick\Sepa\GroupHeader;
use Digitick\Sepa\PaymentInformation;
use Digitick\Sepa\TransferFile\CustomerCreditTransferFile;
use Digitick\Sepa\TransferInformation\CustomerCreditTransferInformation;
use Illuminate\Console\Command;

class ExportController extends Controller
{
    public function index()
    {
        // $users = User::all();
        // // return response()->xml(['user' => $user->toArray()]);
        // $data['users'] = [];
        // foreach($users as $user) {
        //     $data['users'][] = [
        //         'Name' => $user->name,
        //         'email' => $user->email,
        //     ];
        // }
        // return response()->xml(['users' => $data])->header('Content-Disposition', 'attachment; filename="filename.xml"');
        // Create the initiating information
        $groupHeader = new GroupHeader('SEPA File Identifier', 'Your Company Name');
        $sepaFile = new CustomerCreditTransferFile($groupHeader);

        $transfer = new CustomerCreditTransferInformation(
            2, // Amount
            'PT50003300000000000000105', //IBAN of creditor
            'Their Corp' //Name of Creditor
        );
        $transfer->setBic('BCOMPTPL'); // Set the BIC explicitly
        $transfer->setRemittanceInformation('Transaction Description');

        $transfer2 = new CustomerCreditTransferInformation(
            22, // Amount
            'PT50003300000000000000105', //IBAN of creditor
            'Their Corp2' //Name of Creditor
        );
        $transfer2->setBic('BCOMPTPL'); // Set the BIC explicitly
        $transfer2->setRemittanceInformation('Transaction Description2');
        // Create a PaymentInformation the Transfer belongs to
        $payment = new PaymentInformation(
            'Payment Info ID',
            'PT50003300000000000000105', // IBAN the money is transferred from
            'BCOMPTPL',  // BIC
            'My Corp' // Debitor Name
        );
        // It's possible to add multiple Transfers in one Payment
        $payment->addTransfer($transfer);
        $payment->addTransfer($transfer2);

        // It's possible to add multiple payments to one SEPA File
        $sepaFile->addPaymentInformation($payment);

        // Attach a dombuilder to the sepaFile to create the XML output
        $domBuilder = DomBuilderFactory::createDomBuilder($sepaFile, 'pain.001.001.03');

        // Or if you want to use the format 'pain.001.001.03' instead
        // $domBuilder = DomBuilderFactory::createDomBuilder($sepaFile, 'pain.001.001.03');

        // echo($domBuilder->asXml());
        return response()->xml($domBuilder->asXML())->header('Content-Disposition', 'attachment; filename="'."me".'.xml"');

        }
}
