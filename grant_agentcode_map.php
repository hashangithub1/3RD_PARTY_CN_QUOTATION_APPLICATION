<?php
session_start();
require_once('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $agent_codes = isset($_POST['agent_codes']) ? $_POST['agent_codes'] : [];  // Selected agent codes (if any)

    if (!empty($username)) {
        // Step 1: Fetch all currently mapped agent codes for this user
        $sqlMappedCodes = "SELECT agent_code FROM tbl_user_agent_codes WHERE branch_code = ?";
        $stmtMappedCodes = $con->prepare($sqlMappedCodes);
        $stmtMappedCodes->bind_param("s", $username);
        $stmtMappedCodes->execute();
        $resultMapped = $stmtMappedCodes->get_result();

        $existingAgentCodes = [];
        while ($row = $resultMapped->fetch_assoc()) {
            $existingAgentCodes[] = $row['agent_code'];
        }

        // Step 2: Identify agent codes to delete (those that are in the database but not in the submitted form)
        $agentCodesToDelete = array_diff($existingAgentCodes, $agent_codes);
        
        // Step 3: Identify agent codes to add (those that are in the submitted form but not in the database)
        $agentCodesToAdd = array_diff($agent_codes, $existingAgentCodes);

        // Step 4: Delete the agent codes that were unchecked
        if (!empty($agentCodesToDelete)) {
            $deleteQuery = "DELETE FROM tbl_user_agent_codes WHERE branch_code = ? AND agent_code = ?";
            $stmtDelete = $con->prepare($deleteQuery);

            foreach ($agentCodesToDelete as $agent_code) {
                $stmtDelete->bind_param("ss", $username, $agent_code);
                $stmtDelete->execute();
            }
        }

        // Step 5: Add new agent codes that were checked
        if (!empty($agentCodesToAdd)) {
            $insertQuery = "INSERT INTO tbl_user_agent_codes (branch_code, agent_code) VALUES (?, ?)";
            $stmtInsert = $con->prepare($insertQuery);

            foreach ($agentCodesToAdd as $agent_code) {
                $stmtInsert->bind_param("ss", $username, $agent_code);
                $stmtInsert->execute();
            }
        }

        echo "Agent codes successfully updated for the Branch.";
        echo "<script type='text/javascript'> document.location = 'agent_code.php'; </script>";
    } else {
        echo "Please select a Branch.";
        echo "<script type='text/javascript'> document.location = 'agent_code.php'; </script>";
    }
}
?>
