import DeleteFilesButton from "@/Modules/Common/Components/Toolbar/DeleteFiles";
import DownloadFilesButton from "@/Modules/Common/Components/Toolbar/DownloadFiles";
import { Group } from "@mantine/core";

interface IProps {
    selectedIds: string[];
    parentId: string;
}

const SelectedItemToolbar: React.FC<IProps> = ({ selectedIds, parentId }) => (
    <Group
        h="50%"
        px="md"
        align="center"
        justify="flex-start"
    >
        <DeleteFilesButton all={false} ids={selectedIds} />
        <DownloadFilesButton all={false} ids={selectedIds} parentId={parentId} />
    </Group>
);

export default SelectedItemToolbar;