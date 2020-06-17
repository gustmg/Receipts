export const helpers = {
    formatNumberToCurrency: (number) => {
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        });

        return formatter.format(number);
    }
}