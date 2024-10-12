import { Button } from "@mantine/core";
import { IconSelector, IconChevronDown } from "@tabler/icons-react";
import React from "react";

const SortButton = () => {
    return (
        <Button
            variant="subtle"
            color="dark.3"
            leftSection={<IconSelector size={18} />}
            rightSection={<IconChevronDown size={12} />}
        >
            Sort
        </Button>
    );
};

export default SortButton;
