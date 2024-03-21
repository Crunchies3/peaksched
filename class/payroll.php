<?php

class Payroll
{
    private $conn;

    public function runPayroll($payrollId, $startDate, $endDate, $payDate, $federalTax)
    {
        try {
            $stmt = $this->conn->prepare(
                "SELECT DISTINCT a.employee_id
                FROM    tbl_report_employee_hours a,
                        tbl_supervisor_report b
                WHERE   b.report_id = a.report_id && 
                		b.report_date BETWEEN ? AND ?;"
            );
            $stmt->bind_param("ss", $startDate, $endDate);
            $stmt->execute();
            $result = $stmt->get_result();

            $employeeList = array();
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($employeeList, $row);
                }
            }

            $stmt->close();

            $status = 'Pending';

            $stmt = $this->conn->prepare(
                "INSERT INTO tbl_payroll (  payroll_id,
                                            start_date,
                                            end_date,
                                            federal_tax,
                                            pay_date,
                                            status)
                VALUEs (?,?,?,?,?,?);"
            );
            $stmt->bind_param("ssssss", $payrollId, $startDate, $endDate, $federalTax, $payDate, $status);
            $stmt->execute();

            $stmt->close();

            $employeeHoursWorked = array();

            for ($i = 0; $i < count($employeeList); $i++) {
                $stmt = $this->conn->prepare(
                    "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(hours_worked))) AS total_hours
                    FROM    tbl_report_employee_hours a,
                            tbl_supervisor_report b
                    WHERE   b.report_id = a.report_id && 
                            b.report_date BETWEEN ? AND ? &&
                            employee_id = ?;"
                );
                $stmt->bind_param("sss", $startDate, $endDate, $employeeList[$i]['employee_id']);
                $stmt->execute();
                $result2 = $stmt->get_result();

                if ($result2->num_rows > 0) {
                    while ($row2 = $result2->fetch_assoc()) {
                        array_push($employeeHoursWorked, $row2);
                    }
                }
            }

            $stmt->close();

            $employeePayrates = array();

            for ($i = 0; $i < count($employeeList); $i++) {
                $stmt = $this->conn->prepare(
                    "SELECT pay_rate
                    FROM    tbl_employee
                    WHERE   employeeid = ?;"
                );
                $stmt->bind_param("s", $employeeList[$i]['employee_id']);
                $stmt->execute();
                $result3 = $stmt->get_result();

                if ($result3->num_rows > 0) {
                    while ($row3 = $result3->fetch_assoc()) {
                        array_push($employeePayrates, $row3);
                    }
                }
            }

            $stmt->close();

            $payslipId = rand(100000, 200000);

            // TODO: buhatan para mo compute ani
            $grossPay = "";
            $deductions = "";
            $netPay = "" ;

            for ($i = 0; $i < count($employeeList); $i++) {
                $stmt = $this->conn->prepare(
                    "INSERT INTO tbl_payslip (payslip_id, 
                                            payroll_id, 
                                            employee_id,
                                            hours_worked,
                                            gross_pay,
                                            deductions,
                                            net_pay) 
                    VALUES (?,?,?,?,?,?,?);"
                );

                $grossPay = $this->computeGrossPay($employeeHoursWorked[$i]['total_hours'], $employeePayrates[$i]['pay_rate']);
                $deductions = $this->computeDeduction($federalTax,$grossPay);
                $netPay = $this->computenetpay($deductions,$grossPay);

                $stmt->bind_param("sssssss", $payslipId, $payrollId, $employeeList[$i]['employee_id'], $employeeHoursWorked[$i]['total_hours'], $grossPay, $deductions, $netPay);
                $stmt->execute();
                $stmt->close();
            }

            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function computeGrossPay($employeeHoursWorked, $payrate) : float
    {
        $timeParts = explode(':', $employeeHoursWorked);
        $hours = (int)$timeParts[0];
        $minutes = (int)$timeParts[1];
        $totalHours = $hours + ($minutes / 60);
        return $totalHours * $payrate;
    }

    public function computeDeduction($federalTax, $grossPay) :float
    {   
        $taxDecimalValue = $federalTax / 100;
        return $grossPay * $taxDecimalValue;
    }

    public function computeNetPay($deductions, $grossPay) :float
    {
        return $grossPay - $deductions;
    }

    public function fetchPayrollList(){
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.payroll_id,
                        a.pay_date,
                        a.start_date,
                        a.end_date,
                        SUM(b.gross_pay) AS 'TotalGross',
                        SUM(b.net_pay) AS 'TotalNet',
                        COUNT(b.employee_id) AS 'EmployeeCount'
                 FROM tbl_payroll a,
                      tbl_payslip b
                 WHERE a.payroll_id = b.payroll_id
                 GROUP BY a.payroll_id, a.pay_date, a.start_date, a.end_date
                 ");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function fetchEmployeeInsidePayroll($payroll_id){
        try {
            $stmt = $this->conn->prepare(
                "SELECT a.employeeid,
                        CONCAT(a.firstname,' ',a.lastname) AS 'fullname',
                        a.pay_rate,
                        (HOUR(b.hours_worked)+ MINUTE(b.hours_worked)/60+SECOND(b.hours_worked)/3600) AS 'hours_worked',
                        b.gross_pay,
                        b.deductions,
                        b.net_pay
                FROM tbl_employee a,
                     tbl_payslip b
                WHERE a.employeeid = b.employee_id AND
                      b.payroll_id = ?
                ");
            $stmt->bind_param("s",$payroll_id);
            $stmt->execute();
            return $stmt->get_result();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function approvePayroll($payroll_id){
        try {
            $stmt = $this->conn->prepare(
                "UPDATE tbl_payroll SET status = 'Approved' WHERE payroll_id = ?"
            );
            $stmt->bind_param("s",$payroll_id);
            $stmt->execute();
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function employeePayslipDisplayables(){

    }

    public function getConn()
    {
        return $this->conn;
    }

    public function setConn($conn)
    {
        $this->conn = $conn;

        return $this;
    }
}
