import { Link, router } from "@inertiajs/react";
import { Button } from "@mantine/core";
import { IconAdjustments } from "@tabler/icons-react";
import React from "react";

interface IProps {
    parentId?: string;
}

const PropertiesButton: React.FC<IProps> = ({ parentId }) => {
    return (
        <>
            <Button
                variant="subtle"
                component={Link}
                href={route("folder.edit", { id: parentId })}
                color="dark.3"
                leftSection={<IconAdjustments size={18} />}
            >
                Properties
            </Button>
        </>
    );
};

export default PropertiesButton;
