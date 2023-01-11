// helper functions
import {format} from "date-fns";

export const formatMoney = (value, currency) => value.toLocaleString('en', {style: 'currency', currency: currency});

export const formatDate = (date) => format(new Date(date), 'dd-MM-yyyy');
