<?php

namespace Gerencianet;

/**
 * Class Gerencianet
 * @package Gerencianet
 * 
 * API COBRANÇAS
 * @method array createCharge(array $params = [], array $body)
 * @method array createOneStepCharge(array $params = [], array $body)
 * @method array oneStepPartner(array $params = [], array $body)
 * @method array detailCharge(array $params)
 * @method array updateChargeMetadata(array $params, array $body)
 * @method array updateBillet(array $params, array $body)
 * @method array definePayMethod(array $params, array $body)
 * @method array definePayMethodPartner(array $params, array $body)
 * @method array cancelCharge(array $params)
 * @method array createCarnet(array $params = [], array $body)
 * @method array detailCarnet(array $params)
 * @method array updateCarnetParcel(array $params, array $body)
 * @method array updateCarnetMetadata(array $params, array $body)
 * @method array getNotification(array $params)
 * @method array listPlans(array $params)
 * @method array createPlan(array $params = [], array $body)
 * @method array deletePlan(array $params)
 * @method array createSubscription(array $params, array $body)
 * @method array createOneStepSubscription(array $params, array $body)
 * @method array createOneStepSubscriptionLink(array $params, array $body)
 * @method array detailSubscription(array $params)
 * @method array defineSubscriptionPayMethod(array $params, array $body)
 * @method array cancelSubscription(array $params)
 * @method array updateSubscriptionMetadata(array $params, array $body)
 * @method array createSubscriptionHistory(array $params, array $body)
 * @method array sendSubscriptionLinkEmail(array $params, array $body)
 * @method array getInstallments(array $params)
 * @method array sendBilletEmail(array $params, array $body)
 * @method array createChargeHistory(array $params, array $body)
 * @method array sendCarnetEmail(array $params, array $body)
 * @method array sendCarnetParcelEmail(array $params, array $body)
 * @method array createCarnetHistory(array $params, array $body)
 * @method array cancelCarnet(array $params)
 * @method array cancelCarnetParcel(array $params)
 * @method array createOneStepLink(array $params = [], array $body)
 * @method array defineLinkPayMethod(array $params, array $body)
 * @method array updateChargeLink(array $params, array $body)
 * @method array sendLinkEmail(array $params, array $body)
 * @method array updatePlan(array $params, array $body)
 * @method array defineBalanceSheetBillet(array $params, array $body)
 * @method array settleCharge(array $params)
 * @method array settleCarnetParcel(array $params)
 * 
 * API PIX
 * @method array pixConfigWebhook(array $params, array $body)
 * @method array pixDetailWebhook(array $params)
 * @method array pixListWebhook(array $params)
 * @method array pixDeleteWebhook(array $params)
 * @method array pixCreateCharge(array $params, array $body)
 * @method array pixCreateImmediateCharge(array $params = [], array $body)
 * @method array pixDetailCharge(array $params)
 * @method array pixUpdateCharge(array $params, array $body)
 * @method array pixListCharges(array $params)
 * @method array pixGenerateQRCode(array $params)
 * @method array pixDevolution(array $params, array $body)
 * @method array pixDetailDevolution(array $params)
 * @method array pixSend(array $params, array $body)
 * @method array pixSendDetail(array $params)
 * @method array pixSendList(array $params)
 * @method array pixDetail(array $params)
 * @method array pixReceivedList(array $params)
 * @method array pixDetailReceived(array $params)
 * @method array pixCreateLocation(array $params = [], array $body)
 * @method array pixLocationList(array $params)
 * @method array pixDetailLocation(array $params)
 * @method array pixUnlinkTxidLocation(array $params)
 * @method array pixCreateEvp()
 * @method array pixListEvp()
 * @method array pixDeleteEvp(array $params)
 * @method array getAccountBalance()
 * @method array updateAccountConfig(array $params = [], array $body)
 * @method array listAccountConfig()
 * @method array pixCreateDueCharge(array $params, array $body)
 * @method array pixUpdateDueCharge(array $params, array $body)
 * @method array pixDetailDueCharge(array $params)
 * @method array pixListDueCharges(array $params)
 * @method array createReport(array $params = [], array $body)
 * @method string detailReport(array $params)
 * @method string pixSplitDetailCharge(array $params)
 * @method string pixSplitLinkCharge(array $params)
 * @method string pixSplitUnlinkCharge(array $params)
 * @method string pixSplitDetailDueCharge(array $params)
 * @method string pixSplitLinkDueCharge(array $params)
 * @method string pixSplitUnlinkDueCharge(array $params)
 * @method string pixSplitConfig(array $params = [], array $body)
 * @method string pixSplitConfigId(array $params, array $body)
 * @method string pixSplitDetailConfig(array $params)
 * 
 * API OPEN FINANCE
 * @method array ofConfigUpdate(array $params = [], array $body)
 * @method array ofConfigDetail()
 * @method array ofListParticipants(array $params)
 * @method array ofStartPixPayment(array $params = [], array $body)
 * @method array ofDevolutionPix(array $params, array $body)
 * @method array ofListPixPayment(array $params)
 * 
 * API PAYMENTS
 * @method array payDetailBarCode(array $params)
 * @method array payRequestBarCode(array $params, array $body)
 * @method array payDetailPayment(array $params)
 * @method array payListPayments(array $params)
 * 
 * API ABERTURA DE CONTAS
 * @method array createAccount(array $params = [], array $body)
 * @method array getAccountCertificate(array $params)
 * @method array getAccountCredentials(array $params)
 * @method array accountConfigWebhook(array $params = [], array $body)
 * @method array accountDeleteWebhook(array $params)
 * @method array accountDetailWebhook(array $params)
 * @method array accountListWebhook(array $params)
 */
class Gerencianet extends Endpoints
{
    public function __construct($options, $requester = null, $endpointsConfigFile = null)
    {
        if ($endpointsConfigFile) {
            Config::setEndpointsConfigFile($endpointsConfigFile);
        }

        parent::__construct($options, $requester);
    }
}
