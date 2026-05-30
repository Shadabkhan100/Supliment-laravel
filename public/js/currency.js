window.Currency = {

    init(config, current) {
        this.config = config;
        this.current = current;
    },

    format(price) {
        const currency = this.current || this.config.default || "GBP";
        const cfg = this.config?.currencies?.[currency];

        if (!cfg) {
            console.warn("Currency not found:", currency);
            return price;
        }

        return `${cfg.symbol} ${(price * cfg.rate).toFixed(2)}`;
    }
};