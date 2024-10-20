import PermanentDeleteButton from "@/Modules/Common/Components/Toolbar/PermanentDelete";
import RestoreFilesButton from "@/Modules/Common/Components/Toolbar/RestoreFiles";
import { Button, Group } from "@mantine/core";
import { IconTrashX } from "@tabler/icons-react";

interface IProps {
    selectedIds: string[];
}

const TrashSelectedToolbar: React.FC<IProps> = ({ selectedIds }) => {
    return (
        <Group
            h="50%"
            px="md"
            align="center"
            justify="flex-start"
        >
            <PermanentDeleteButton all={false} ids={selectedIds} />
            <RestoreFilesButton all={false} ids={selectedIds} />
        </Group>
    );
};

export default TrashSelectedToolbar;
