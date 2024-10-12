import { Button } from "@mantine/core";
import { IconArticle } from "@tabler/icons-react";
import React from "react";

const ActivityButton = () => {
    return (
        <Button
            variant="subtle"
            color="dark.3"
            leftSection={<IconArticle size={18} />}
        >
            Activity
        </Button>
    );
};

export default ActivityButton;
