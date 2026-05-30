function formatPrice(price) {

  const currency = window.currentCurrency || "USD";

  const config = currencyMap[currency] || currencyMap.USD;

  const converted = price * config.rate;

  return `${config.symbol} ${converted.toFixed(2)}`;
}