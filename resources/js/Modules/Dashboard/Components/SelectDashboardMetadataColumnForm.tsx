// resources/js/Modules/Dashboard/Components/SelectDashboardMetadataColumnForm.tsx
import React, { useEffect } from "react";
import { Modal, Stack, Text, Checkbox, Group, Button } from "@mantine/core";
import { useDashboardMetadata } from "../Hooks/use-dashboard-metadata";
import useModalStore from "@/Modules/Common/Hooks/use-modal-store";
import { DashboardMetadataResourceData } from "../Types/DashboardMetadataResourceData";

interface SelectDashboardMetadataColumnFormProps {
    folderId: string;
    availableMetadata: DashboardMetadataResourceData[];
    existingMetadataIds: number[];
}

const SelectDashboardMetadataColumnForm: React.FC<SelectDashboardMetadataColumnFormProps> = ({
    folderId,
    availableMetadata,
    existingMetadataIds,
}) => {
    const { modals, closeModal } = useModalStore();
    const isOpen = modals["selectDashboardMetadataColumns"];
    const { data, setData, handleSubmit, processing, errors } = useDashboardMetadata({
        folderId,
        closeModal: () => closeModal("selectDashboardMetadataColumns"),
    });

    useEffect(() => {
        setData("metadata_ids", existingMetadataIds);
    }, [existingMetadataIds]);

    const handleCheckboxChange = (metadataId: number) => {
        const current = data.metadata_ids;
        if (current.includes(metadataId)) {
            setData(
                "metadata_ids",
                current.filter((id) => id !== metadataId)
            );
        } else {
            setData("metadata_ids", [...current, metadataId]);
        }
    };

    return (
        <Modal
            opened={isOpen}
            onClose={() => closeModal("selectDashboardMetadataColumns")}
            title="Select Metadata Columns"
        >
            <form onSubmit={(e) => { e.preventDefault(); handleSubmit(); }}>
                <Stack>
                    <Text>Select the metadata columns you want to display in the dashboard report:</Text>
                    {availableMetadata.map((meta) => (
                        <Checkbox
                            key={meta.id}
                            label={meta.name}
                            checked={data.metadata_ids.includes(meta.id)}
                            onChange={() => handleCheckboxChange(meta.id)}
                        />
                    ))}
                    {errors.metadata_ids && (
                        <Text c="red">{errors.metadata_ids}</Text>
                    )}
                    <Group gap="md" mt="md">
                        <Button variant="outline" onClick={() => closeModal("selectDashboardMetadataColumns")}>
                            Cancel
                        </Button>
                        <Button type="submit" loading={processing}>
                            Save
                        </Button>
                    </Group>
                </Stack>
            </form>
        </Modal>
    );
};

export default SelectDashboardMetadataColumnForm;