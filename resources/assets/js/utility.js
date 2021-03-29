
export default class PaymentUtility {

    static netToGross(amount, percentage, fixed)
    {
        let result;
        result = (parseFloat(amount) + parseFloat(fixed)) / (1 - parseFloat(percentage) / 100);
        return result.toFixed(1);
    }
}