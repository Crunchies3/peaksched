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

            $payslipId = rand(100000, 200000);

            // TODO: buhatan para mo compute ani
            $grossPay = "";
            $deductions = "";
            $netPay = "";

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

                $grossPay = $this->computeGrossPay($employeeHoursWorked[$i]['total_hours'], 40);

                $stmt->bind_param("sssssss", $payslipId, $payrollId, $employeeList[$i]['employee_id'], $employeeHoursWorked[$i]['total_hours'], $grossPay, $deductions, $netPay);
                $stmt->execute();
                $stmt->close();
            }

            return $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public function computeGrossPay($employeeHoursWorked, $payrate)
    {
    }

    public function computeDeduction($federalTax, $grossPay)
    {
    }

    public function computeNetPay($deductions, $grossPay)
    {
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
