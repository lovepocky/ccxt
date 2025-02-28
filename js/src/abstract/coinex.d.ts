import { implicitReturnType } from '../base/types.js';
import { Exchange as _Exchange } from '../base/Exchange.js';
interface Exchange {
    publicGetAmmMarket(params?: {}): Promise<implicitReturnType>;
    publicGetCommonCurrencyRate(params?: {}): Promise<implicitReturnType>;
    publicGetCommonAssetConfig(params?: {}): Promise<implicitReturnType>;
    publicGetCommonMaintainInfo(params?: {}): Promise<implicitReturnType>;
    publicGetCommonTempMaintainInfo(params?: {}): Promise<implicitReturnType>;
    publicGetMarginMarket(params?: {}): Promise<implicitReturnType>;
    publicGetMarketInfo(params?: {}): Promise<implicitReturnType>;
    publicGetMarketList(params?: {}): Promise<implicitReturnType>;
    publicGetMarketTicker(params?: {}): Promise<implicitReturnType>;
    publicGetMarketTickerAll(params?: {}): Promise<implicitReturnType>;
    publicGetMarketDepth(params?: {}): Promise<implicitReturnType>;
    publicGetMarketDeals(params?: {}): Promise<implicitReturnType>;
    publicGetMarketKline(params?: {}): Promise<implicitReturnType>;
    publicGetMarketDetail(params?: {}): Promise<implicitReturnType>;
    privateGetAccountAmmBalance(params?: {}): Promise<implicitReturnType>;
    privateGetAccountInvestmentBalance(params?: {}): Promise<implicitReturnType>;
    privateGetAccountBalanceHistory(params?: {}): Promise<implicitReturnType>;
    privateGetAccountMarketFee(params?: {}): Promise<implicitReturnType>;
    privateGetBalanceCoinDeposit(params?: {}): Promise<implicitReturnType>;
    privateGetBalanceCoinWithdraw(params?: {}): Promise<implicitReturnType>;
    privateGetBalanceInfo(params?: {}): Promise<implicitReturnType>;
    privateGetBalanceDepositAddressCoinType(params?: {}): Promise<implicitReturnType>;
    privateGetContractTransferHistory(params?: {}): Promise<implicitReturnType>;
    privateGetCreditInfo(params?: {}): Promise<implicitReturnType>;
    privateGetCreditBalance(params?: {}): Promise<implicitReturnType>;
    privateGetInvestmentTransferHistory(params?: {}): Promise<implicitReturnType>;
    privateGetMarginAccount(params?: {}): Promise<implicitReturnType>;
    privateGetMarginConfig(params?: {}): Promise<implicitReturnType>;
    privateGetMarginLoanHistory(params?: {}): Promise<implicitReturnType>;
    privateGetMarginTransferHistory(params?: {}): Promise<implicitReturnType>;
    privateGetOrderDeals(params?: {}): Promise<implicitReturnType>;
    privateGetOrderFinished(params?: {}): Promise<implicitReturnType>;
    privateGetOrderPending(params?: {}): Promise<implicitReturnType>;
    privateGetOrderStatus(params?: {}): Promise<implicitReturnType>;
    privateGetOrderStatusBatch(params?: {}): Promise<implicitReturnType>;
    privateGetOrderUserDeals(params?: {}): Promise<implicitReturnType>;
    privateGetOrderStopFinished(params?: {}): Promise<implicitReturnType>;
    privateGetOrderStopPending(params?: {}): Promise<implicitReturnType>;
    privateGetOrderUserTradeFee(params?: {}): Promise<implicitReturnType>;
    privateGetOrderMarketTradeInfo(params?: {}): Promise<implicitReturnType>;
    privateGetSubAccountBalance(params?: {}): Promise<implicitReturnType>;
    privateGetSubAccountTransferHistory(params?: {}): Promise<implicitReturnType>;
    privateGetSubAccountAuthApi(params?: {}): Promise<implicitReturnType>;
    privateGetSubAccountAuthApiUserAuthId(params?: {}): Promise<implicitReturnType>;
    privatePostBalanceCoinWithdraw(params?: {}): Promise<implicitReturnType>;
    privatePostContractBalanceTransfer(params?: {}): Promise<implicitReturnType>;
    privatePostMarginFlat(params?: {}): Promise<implicitReturnType>;
    privatePostMarginLoan(params?: {}): Promise<implicitReturnType>;
    privatePostMarginTransfer(params?: {}): Promise<implicitReturnType>;
    privatePostOrderLimitBatch(params?: {}): Promise<implicitReturnType>;
    privatePostOrderIoc(params?: {}): Promise<implicitReturnType>;
    privatePostOrderLimit(params?: {}): Promise<implicitReturnType>;
    privatePostOrderMarket(params?: {}): Promise<implicitReturnType>;
    privatePostOrderModify(params?: {}): Promise<implicitReturnType>;
    privatePostOrderStopLimit(params?: {}): Promise<implicitReturnType>;
    privatePostOrderStopMarket(params?: {}): Promise<implicitReturnType>;
    privatePostOrderStopModify(params?: {}): Promise<implicitReturnType>;
    privatePostSubAccountTransfer(params?: {}): Promise<implicitReturnType>;
    privatePostSubAccountRegister(params?: {}): Promise<implicitReturnType>;
    privatePostSubAccountUnfrozen(params?: {}): Promise<implicitReturnType>;
    privatePostSubAccountFrozen(params?: {}): Promise<implicitReturnType>;
    privatePostSubAccountAuthApi(params?: {}): Promise<implicitReturnType>;
    privatePutBalanceDepositAddressCoinType(params?: {}): Promise<implicitReturnType>;
    privatePutSubAccountAuthApiUserAuthId(params?: {}): Promise<implicitReturnType>;
    privatePutV1AccountSettings(params?: {}): Promise<implicitReturnType>;
    privateDeleteBalanceCoinWithdraw(params?: {}): Promise<implicitReturnType>;
    privateDeleteOrderPendingBatch(params?: {}): Promise<implicitReturnType>;
    privateDeleteOrderPending(params?: {}): Promise<implicitReturnType>;
    privateDeleteOrderStopPending(params?: {}): Promise<implicitReturnType>;
    privateDeleteOrderStopPendingId(params?: {}): Promise<implicitReturnType>;
    privateDeleteSubAccountAuthApiUserAuthId(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetPing(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetTime(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketList(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketLimitConfig(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketTicker(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketTickerAll(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketDepth(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketDeals(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketFundingHistory(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketUserDeals(params?: {}): Promise<implicitReturnType>;
    perpetualPublicGetMarketKline(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetAssetQuery(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderPending(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderFinished(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderStopFinished(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderStopPending(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderStatus(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetOrderStopStatus(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetPositionPending(params?: {}): Promise<implicitReturnType>;
    perpetualPrivateGetPositionFunding(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostMarketAdjustLeverage(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostMarketPositionExpect(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderPutLimit(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderPutMarket(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderPutStopLimit(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderPutStopMarket(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderModify(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderModifyStop(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCancel(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCancelAll(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCancelBatch(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCancelStop(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCancelStopAll(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCloseLimit(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostOrderCloseMarket(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostPositionAdjustMargin(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostPositionStopLoss(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostPositionTakeProfit(params?: {}): Promise<implicitReturnType>;
    perpetualPrivatePostPositionMarketClose(params?: {}): Promise<implicitReturnType>;
}
declare abstract class Exchange extends _Exchange {
}
export default Exchange;
