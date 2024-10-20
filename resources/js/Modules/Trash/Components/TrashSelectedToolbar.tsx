import PermanentDeleteButton from "@/Modules/Common/Components/Toolbar/PermanentDelete";
import RestoreFilesButton from "@/Modules/Common/Components/Toolbar/RestoreFiles";
import { Button, Group } from "@mantine/core";
import { IconRestore, IconTrash, IconTrashX } from "@tabler/icons-react";
import PermanentDeleteForm from "../Forms/PermanentDeleteForm";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import RestoreFilesForm from "../Forms/RestoreFilesForm";

interface IProps {
    selectedIds: string[];
}

const TrashSelectedToolbar: React.FC<IProps> = ({ selectedIds }) => {
    const { openModal } = useModalStore();

    return (
        <Group
            h="50%"
            px="md"
            align="center"
            justify="flex-start"
        >
            {/* <PermanentDeleteButton all={false} ids={selectedIds} />
            <RestoreFilesButton all={false} ids={selectedIds} /> */}

            <Button
                variant="subtle"
                color="dark.3"
                leftSection={<IconTrash size={18} />}
                onClick={() => openModal("permanentDelete")}
            >
                Delete Forever
            </Button>

            <Button
                variant="subtle"
                color="green"
                leftSection={<IconRestore size={18} />}
                onClick={() => openModal("restoreFiles")}
            >
                Restore
            </Button>

            <PermanentDeleteForm deleteIds={selectedIds} />
            <RestoreFilesForm restoreIds={selectedIds} />
        </Group>
    );
};

export default TrashSelectedToolbar;
