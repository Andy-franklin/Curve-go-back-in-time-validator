# Curve "Go Back In Time" Validator

Checks that Curve has squared away transactions when using the "Go Back In Time" feature of the app.

Allows you to quickly see any unsettled transactions and investigate further.


## How to use
1. Download bank statement from your bank app
2. Modify constants in `Process.php` to reflect the layout of the csv statement
3. Add the csv to the input folder
4. Run `php Process.php`


### Input Example
![Alt text](inputExample.png?raw=true "Title")

### Output Example

Script output:

```
26504868_20213917_0212.csv
Curve Debits: 7
Curve Credits: 6
Unsettled: 1
Settled: 6
```

File Output:

![Alt text](outputExample.png?raw=true "Title")


## What is go back in time?
https://help.curve.com/what-is-go-back-in-time-ByrH_2U_#:~:text=Go%20Back%20in%20Time%20allows,done%20entirely%20in%20the%20app!

## My Referral

I have not had any issue with payments not being paid back to my account yet - I am just paranoid and threw this script together to make sure I can quickly verify that I have not been charged twice.

If you want to use Curve and are not already - using this link will give us both £5 + 1% cashback for 1 month.

https://www.curve.com/join#EAPR4R2E