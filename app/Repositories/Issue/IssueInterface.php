<?php
namespace App\Repositories\Issue;

interface IssueInterface
{
    public function getIssueList($input =[]);
    public function getListCustomerLate3Month();
    public function createNewCustomer($input);
    public function createOutOfRiceIssue($input = []);
    public function updateIssue($id = null, $input = []); // With base
    public function createIssue($input = []); // With base
}
