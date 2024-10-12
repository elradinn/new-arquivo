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

interface IProps {
    page: "item" | "trash";
    uploadFileRef?: React.RefObject<() => void>;
    fileSelected?: boolean;
    selectedIds?: string[];
    folderId?: number;
    approvalActive?: boolean;
    trackingActive?: boolean;
}

const Toolbar: React.FC<IProps> = ({
    page,
    uploadFileRef,
    fileSelected,
    selectedIds,
    folderId,
    approvalActive,
    trackingActive,
}) => {

    return (
        <Group
            h="50%"
            px="md"
            align="center"
            justify={!fileSelected ? "space-between" : "flex-start"}
        >
            {!fileSelected ? (
                page === "item" ? (
                    <>
                        <div>
                            <NewFilesButton uploadFileRef={uploadFileRef} />

                            <PropertiesButton folderId={folderId} />

                            <ApprovalButton approvalActive={approvalActive} />

                            <MetadataButton />

                            <ActivityButton />

                            <TrackingButton trackingActive={trackingActive} />

                            <ColumnButton />
                        </div>

                        <div>
                            <SortButton />

                            <ViewButton />
                        </div>
                    </>
                ) : (
                    <EmptyBinButton />
                )
            ) : page === "item" ? (
                <>

                    <DeleteFilesButton all={false} ids={selectedIds} />

                    <DownloadFilesButton all={false} ids={selectedIds} />
                </>
            ) : (
                <>
                    <PermanentDeleteButton all={false} ids={selectedIds} />

                    <RestoreFilesButton all={false} ids={selectedIds} />
                </>
            )}
        </Group>
    );
};

export default Toolbar;