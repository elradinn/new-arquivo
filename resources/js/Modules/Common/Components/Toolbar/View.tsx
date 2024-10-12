import { Button } from "@mantine/core";
import { IconLayoutGrid, IconChevronDown } from "@tabler/icons-react";
import React from "react";

const ViewButton = () => {
    return (
        <Button
            variant="subtle"
            color="dark.3"
            leftSection={<IconLayoutGrid size={18} />}
            rightSection={<IconChevronDown size={12} />}
        >
            View
        </Button>
    );
};

export default ViewButton;
