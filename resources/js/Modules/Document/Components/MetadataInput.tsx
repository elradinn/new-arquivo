import React, { useMemo } from "react";
import { Group, ActionIcon, TextInput, Button, Stack, Text, Alert } from "@mantine/core";
import { IconPlus, IconTrash, IconAlertCircle } from "@tabler/icons-react";
import { DocumentMetadata } from "../Types/DocumentMetadata";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import AddDocumentMetadataModal from "./AddDocumentMetadataModal";
import { FolderRequiredMetadataResource } from "@/Modules/Folder/Types/FolderRequiredMetadataResource";

interface MetadataInputProps {
    metadata: DocumentMetadata[];
    requiredMetadata: FolderRequiredMetadataResource[];
    onChange?: (metadata: DocumentMetadata[]) => void;
    onDelete?: (metadataId: number) => void;
}

const MetadataInput: React.FC<MetadataInputProps> = ({ metadata, requiredMetadata, onChange, onDelete }) => {
    const { openModal } = useModalStore();

    const handleAddMetadata = (newMetadata: DocumentMetadata) => {
        const updatedMetadata = [...metadata, newMetadata];
        onChange && onChange(updatedMetadata);
    };

    const handleAddCustomMetadata = () => {
        openModal("addDocumentMetadata");
    };

    const handleRemove = (index: number) => {
        const removedMeta = metadata[index];
        const newMetadata = metadata.filter((_, i) => i !== index);
        onChange && onChange(newMetadata);
        onDelete && removedMeta.metadata_id !== 0 && onDelete(removedMeta.metadata_id);
    };

    const handleChange = (index: number, field: keyof DocumentMetadata, value: string) => {
        const newMetadata = metadata.map((item, i) => (i === index ? { ...item, [field]: value } : item));
        onChange && onChange(newMetadata);
    };

    // Compute missing required metadata
    const missingRequiredMetadata = useMemo(() => {
        const existingIds = metadata.map(meta => meta.metadata_id);
        return requiredMetadata.filter(required => !existingIds.includes(required.id));
    }, [metadata, requiredMetadata]);

    return (
        <Stack>
            {metadata.map((meta, index) => (
                <Group key={meta.metadata_id || index} grow align="flex-end">
                    <TextInput
                        disabled
                        label="Name"
                        placeholder="Metadata name"
                        value={meta.name}
                        onChange={(e) => handleChange(index, "name", e.target.value)}
                    />
                    <TextInput
                        label="Value"
                        placeholder="Metadata value"
                        value={meta.value}
                        onChange={(e) => handleChange(index, "value", e.target.value)}
                    />
                    <ActionIcon color="red" onClick={() => handleRemove(index)}>
                        <IconTrash size={16} />
                    </ActionIcon>
                </Group>
            ))}

            {/* Display warnings for missing required metadata */}
            {missingRequiredMetadata.length > 0 && (
                <Stack gap="xs">
                    <Text c="red" size="sm">
                        Missing Required Metadata:
                    </Text>
                    {missingRequiredMetadata.map(required => (
                        <Alert
                            icon={<IconAlertCircle size={16} />}
                            title={`${required.name} is missing`}
                            color="red"
                            variant="light"
                            key={required.id}
                        />
                    ))}
                </Stack>
            )}

            <Button variant="light" onClick={handleAddCustomMetadata} leftSection={<IconPlus size={14} />}>
                Add Custom Metadata
            </Button>
            <AddDocumentMetadataModal onAdd={(meta) => handleAddMetadata({
                metadata_id: meta.id,
                name: meta.name,
                value: "",
            })} />
        </Stack>
    );
};

export default MetadataInput;
