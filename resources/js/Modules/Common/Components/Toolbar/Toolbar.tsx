import React from "react";
import { Group } from "@mantine/core";
import NewFilesButton from "./NewFiles";
import PropertiesButton from "./Properties";
import MetadataButton from "./Metadata";
import ActivityButton from "./Activity";
import TrackingButton from "./Tracking";
import ColumnButton from "./Column";
import SortButton from "./Sort";
import ViewButton from "./View";
import DeleteFilesButton from "./DeleteFiles";
import DownloadFilesButton from "./DownloadFiles";
import EmptyBinButton from "./EmptyBin";
import PermanentDeleteButton from "./PermanentDelete";
import RestoreFilesButton from "./RestoreFiles";
import ApprovalButton from "./Approval";
import MoveButton from "./Move";
import { ItemParentResourceData } from "@/Modules/Item/Types/ItemParentResourceData";

interface IProps {
    page: "item" | "trash" | "folder";
    uploadFileRef?: React.RefObject<() => void>;
    fileSelected?: boolean;
    selectedIds?: string[];
    parentId?: string;
    approvalActive?: boolean;
    trackingActive?: boolean;
    itemParent?: ItemParentResourceData;
}

const ItemToolbar: React.FC<IProps> = ({ uploadFileRef, itemParent, parentId, approvalActive, trackingActive }) => (
    <>
        <div>
            <NewFilesButton uploadFileRef={uploadFileRef} itemParent={itemParent} />
            <PropertiesButton parentId={parentId} />
            <ApprovalButton approvalActive={approvalActive} />
            <MetadataButton />
            <ActivityButton />
            <TrackingButton trackingActive={itemParent?.has_active_numbering_scheme} folderItemId={parentId} />
            <ColumnButton />
        </div>
        <div>
            <SortButton />
            <ViewButton />
        </div>
    </>
);

const FolderToolbar: React.FC<IProps> = ({ selectedIds, parentId }) => (
    <Group>
        <MoveButton ids={selectedIds} />
        <DeleteFilesButton all={false} ids={selectedIds} />
        <DownloadFilesButton all={false} ids={selectedIds} parentId={parentId} />
    </Group>
);

const TrashToolbar: React.FC = () => <EmptyBinButton />;

const SelectedItemToolbar: React.FC<IProps> = ({ selectedIds, parentId }) => (
    <>
        <DeleteFilesButton all={false} ids={selectedIds} />
        <DownloadFilesButton all={false} ids={selectedIds} parentId={parentId} />
    </>
);

const SelectedTrashToolbar: React.FC<IProps> = ({ selectedIds }) => (
    <>
        <PermanentDeleteButton all={false} ids={selectedIds} />
        <RestoreFilesButton all={false} ids={selectedIds} />
    </>
);

const Toolbar: React.FC<IProps> = ({ page, fileSelected, ...props }) => {
    let toolbarContent;

    if (!fileSelected) {
        if (page === "item") {
            toolbarContent = <ItemToolbar page={page} {...props} />;
        } else if (page === "trash") {
            toolbarContent = <TrashToolbar />;
        } else if (page === "folder") {
            toolbarContent = <FolderToolbar page={page} {...props} />;
        }
    } else {
        if (page === "item") {
            toolbarContent = <SelectedItemToolbar page={page} {...props} />;
        } else if (page === "trash") {
            toolbarContent = <SelectedTrashToolbar page={page} {...props} />;
        }
    }

    return (
        <Group
            h="50%"
            px="md"
            align="center"
            justify={!fileSelected ? "space-between" : "flex-start"}
        >
            {toolbarContent}
        </Group>
    );
};

export default Toolbar;
