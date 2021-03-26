
class PaymentUtility {

    static netToGross(amount, percentage, fixed)
    {
        let result;
        result = (amount + fixed) / (1 - percentage / 100);
        return Math.ceil(result);
    }
}