<?php
require_once('includes/config.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Query to fetch all agent codes
    $sqlAgentCodes = "SELECT agent_code FROM tbl_agent_codes";
    $resultAgents = $con->query($sqlAgentCodes);

    $agentCodes = [];
    while ($row_agents = $resultAgents->fetch_assoc()) {
        $agentCodes[] = $row_agents['agent_code'];
    }

    // Query to fetch agent codes that are already mapped to the selected username
    $sqlMappedCodes = "SELECT agent_code FROM tbl_user_agent_codes WHERE branch_code = '$username'";
    $resultMapped = $con->query($sqlMappedCodes);

    $mappedCodes = [];
    while ($row_mapped = $resultMapped->fetch_assoc()) {
        $mappedCodes[] = $row_mapped['agent_code'];
    }

    // Return both lists as JSON response
    echo json_encode(['agentCodes' => $agentCodes, 'mappedCodes' => $mappedCodes]);
    exit;
}
?>
