import {
    IconFolder,
    IconPhoto,
    IconFileTypePdf,
    IconFileMusic,
    IconVideo,
    IconFileWord,
    IconFileSpreadsheet,
    IconFileZip,
    IconFileText,
    IconFile,
} from "@tabler/icons-react";
import {
    isAudio,
    isExcel,
    isImage,
    isPDF,
    isText,
    isVideo,
    isWord,
    isZip,
} from "@/Modules/Item/Helpers/file-helper";
import { Indicator } from "@mantine/core";
import { getColorStatus } from "@/Modules/Common/Helpers/get-color-status";

interface ItemIconProps {
    mime: string;
    isFolder: boolean;
    approvalStatus?: string | undefined;
}

export const ItemIcon: React.FC<ItemIconProps> = ({ mime, isFolder, approvalStatus }) => {
    const renderIcon = () => {
        if (isFolder) {
            return <IconFolder size={20} fill="orange" color="orange" />;
        } else if (isImage(mime)) {
            return <IconPhoto size={20} />;
        } else if (isPDF(mime)) {
            return <IconFileTypePdf size={20} />;
        } else if (isAudio(mime)) {
            return <IconFileMusic size={20} />;
        } else if (isVideo(mime)) {
            return <IconVideo size={20} />;
        } else if (isWord(mime)) {
            return <IconFileWord size={20} />;
        } else if (isExcel(mime)) {
            return <IconFileSpreadsheet size={20} />;
        } else if (isZip(mime)) {
            return <IconFileZip size={20} />;
        } else if (isText(mime)) {
            return <IconFileText size={20} />;
        }
        return <IconFile size={20} />;
    };

    const indicatorColor = getColorStatus(approvalStatus);

    return indicatorColor ? (
        <Indicator position="bottom-end" color={indicatorColor}>
            {renderIcon()}
        </Indicator>
    ) : (
        renderIcon()
    );
};
