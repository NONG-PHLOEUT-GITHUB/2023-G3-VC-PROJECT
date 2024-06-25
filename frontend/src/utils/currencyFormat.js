import accounting from "accounting";
 
export function formatCurrency(value, options = {}) {
  const defaultOptions = {
    symbol: "€", // Remove currency symbol
    thousand: " ", // Use space as thousands separator
    point: ".",
    decimal: ",", // Use comma as decimal separator
    precision: 3, // 3 digits after the decimal point
    format: {
      pos: "%v", // Format for positive values (value only)
      neg: "-%v", // Format for negative values (value only)
      zero: "%v", // Format for zero (value only)
    },
  };
 
  const mergedOptions = { ...defaultOptions, ...options };
 
  return accounting.formatMoney(value, mergedOptions) + " " + mergedOptions.symbol;
}